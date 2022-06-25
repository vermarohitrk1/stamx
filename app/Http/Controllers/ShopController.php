<?php

namespace App\Http\Controllers;

use App\ShopProduct;
use App\ShopCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Utility;
use App\Order;
use File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DataTables;
use LaraCart;
use Carbon\Carbon;

class ShopController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request,$view = null, $views = null)
    {
        
        $user = Auth::user();
        $authuser = $user;
        $title = "Shop Dashboard";
        $stats =[];
        if (isset($_GET['views'])) {
            $typeview = $_GET['views'];
        } else {
            $typeview = null;
        }
        if ($request->ajax() && !empty($request->blockElementsData)) {
                if (!empty($request->duration)) {
                    $tilldate = Carbon::now()->addMonth($request->duration)->toDateTimeString();
                }
                
         $data = ShopProduct::where("user_id", $user->id)->orderBy("id", "desc")->get();
        $stats['total_products'] = !empty($data) ? count($data) : 0;
        $total_revenue= 0;
        $total_sales= 0;
        $my_orders = \App\ProductOrder::where('user_id', $user->id);
         if (!empty($tilldate)) {
                    $my_orders->where("created_at", ">", $tilldate);
                }
                        $my_orders=$my_orders->count();
        foreach ($data as $row) {
            $total_revenue1 = ShopProduct::find($row->id)->orders->where('product_id', $row->id);
        if (!empty($tilldate)) {
                    $total_revenue1->where("created_at", ">", $tilldate);
                }
                        $total_revenue1=$total_revenue1->sum("amount");
                        $total_revenue = $total_revenue+$total_revenue1;
            $total_sales1 = ShopProduct::find($row->id)->orders->where('product_id', $row->id);
        if (!empty($tilldate)) {
                    $total_sales1->where("created_at", ">", $tilldate);
                }
                        $total_sales1=$total_sales1->count();
                        $total_sales =$total_sales+$total_sales1;
        }
        
       
                     $products = ShopProduct::where("user_id", $user->id);
        if (!empty($tilldate)) {
                    $products->where("created_at", ">", $tilldate);
                }
                        $products=$products->count();
         
               
                    
                    
                        return json_encode([
                    'myorders' => $my_orders,
                    'products' => $products,
                    'sales' => $total_sales,
                    'revenue' => format_price($total_revenue),
                ]);
                
                
                
         }else{

        $data = ShopProduct::where("user_id", $user->id)->orderBy("id", "desc")->get();
        $stats['total_products'] = !empty($data) ? count($data) : 0;
        $stats['total_revenue'] = 0;
        $stats['total_sales'] = 0;
        $stats['my_orders'] = \App\ProductOrder::where('user_id', $user->id)->count();
        foreach ($data as $row) {
            $stats['total_revenue'] += ShopProduct::find($row->id)->orders->where('product_id', $row->id)->sum("amount");
            $stats['total_sales'] += ShopProduct::find($row->id)->orders->where('product_id', $row->id)->count();
        }
        return view('shop.dashboard', compact('typeview', 'stats', 'title'));
         }
    }
    public function stripe_integration()
    {
        $user = Auth::user();
        if($user->type=="admin"){
            return redirect()->back()->with('error', __('Admin Dont Need To Integrate'));
        }
        return view('shop.stripeintegrate');
    }

    public function published($views = null , Request $request)
    {
        $user = Auth::user();
        $authuser = $user;
        if ($request->ajax()) {  
            $data = \App\ProductOrder::join('shopproducts as s', 's.id', '=', 'product_orders.product_id')
                    ->select('product_orders.*','s.title','s.user_id as product_user')                    
                    ->orderBy("product_orders.id", "desc");
            
            switch ($request->filter_type){
                case 'Pending':
                case 'Shipped':
                case 'Cancelled':
                 $data->where('product_orders.status',$request->filter_type);
                    $data->WhereRaw(' (product_orders.user_id='.$user->id.' OR s.user_id='.$user->id.' OR product_orders.drop_shipper='.$user->id.')');
                    break;
                case 'dropshipped':
                    $data->WhereRaw(' (product_orders.drop_shipper='.$user->id.')');
                    break;
                case 'dropshipping':
                    $data->WhereRaw(' (product_orders.user_id='.$user->id.' AND product_orders.drop_shipper !='.$user->id.' AND product_orders.drop_shipper !=0 )');
                    break;    
                default:
                    $data->WhereRaw(' (product_orders.user_id='.$user->id.' OR s.user_id='.$user->id.' OR product_orders.drop_shipper='.$user->id.')');
                    break;
            }
           

            //status
            if (!empty($request->filter_category)) {
                $data->where('cf.folder_id', $request->filter_category);
            }

            //keyword
            if (!empty($request->keyword)) {
                $data->WhereRaw('(s.title LIKE "%' . $request->keyword . '%" OR product_orders.order_id LIKE "%' . $request->keyword . '%")');
            }
            
            
            
          
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('product_id', function($query, $keyword) use ($request) {
                    $query->orWhere('product_orders.product_id', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('s.title', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('product_orders.amount', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('product_orders.created_at', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('product_orders.status', 'LIKE', '%' . $keyword . '%')
                   ;
                })
                ->addColumn('name', function ($data) {
                    $user = Auth::user();
                    
                       $paidto = \App\User::find($data->user_id);
                       if(!empty($paidto)){
                                return '<h2 class="table-avatar">
                                                <a href="' . route('profile', ['id' => encrypted_key($paidto->id, 'encrypt')]) . '" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="' . $paidto->getAvatarUrl() . '" alt="Image"></a>
                                                <a href="' . route('profile', ['id' => encrypted_key($paidto->id, 'encrypt')]) . '">' . $paidto->name . '</a>
                                            </h2>';
                       }else{
                           return '';
                       }
               

                 }) 
                ->addColumn('payment', function ($data) {
                    return  $data->payment_type." - ".$data->payment_status;

                 }) 

                ->addColumn('order', function ($data) {
                    $payment= \App\UserPayment::where('order_id',$data->cart_id)->first();
                 if(!empty($payment)){
                     return '<a target="_blank" href="'.route('payment.invoice', encrypted_key($payment->id, 'encrypt')).'">'. (!empty($data->order_id) ? $data->order_id :'View Order' ).' </a>';
                 }else{
                     return '';
                 }

                 }) 
                 ->addColumn('title', function ($data) {
                    

                    return '<a href="'.route('shop.product.details',encrypted_key($data->product_id,'encrypt')).'">'. (!empty($data->title) ? ucfirst(substr(strip_tags($data->title) ,0,35)).'..' :'View Details' ).' </a>';
                 }) 

                 ->addColumn('amount', function ($data) {
                    return number_format($data->amount, 2);
                 }) 
                
                ->addColumn('status', function ($data) {
                   return  ' <span class="btn btn-xs bg-'.($data->status == 'Shipped' ? "success":($data->status == 'Pending' ? "primary":'danger')).'-light">
                   '. $data->status .'
               </span>  ';     
                }) 
                ->addColumn('created_at', function ($data) {
                    if(!empty($data->created_at)){
                    return \App\Utility::getDateFormated($data->created_at);
                      }else{
                     return '';
                 }
                 }) 

               
                ->addColumn('action', function($row){
                    $actionBtn='';
                    if($row->status != 'Shipped' && $row->product_user ==Auth::User()->id) {
                    if($row->status != 'Cancelled'){
                    $actionBtn = ' 
                    <a href="'.route('shop.markshipped',encrypted_key($row->id,'encrypt')).'" class="btn btn-sm btn-icon-only rounded-pill mr-1 ml-1" title="Mark Shipped" data-toggle="tooltip" data-original-title="'.__('Mark Shipped').'">
                    <i class="fas fa-shopping-cart text-success"></i>
                </a>
                <a href="'.route('shop.markcancel',encrypted_key($row->id,'encrypt')).'" class="btn btn-sm  btn-icon-only rounded-pill mr-1 ml-1" title="Mark Cancel" data-toggle="tooltip" data-original-title='.__('Mark Cancel').'">
                    <i class="fas fa-trash-alt text-danger"></i>
                </a>';
                  
                }
                    }
                    if( $row->product_user !=Auth::User()->id){
                    $actionBtn .=' <a href="'.route('support.create',['for'=>$row->product_user,'entity_type'=>'Shop Order','entity_id'=>$row->id]).'" class="btn btn-sm  btn-icon-only rounded-pill mr-1 ml-1" title="Raise Support Ticket" data-toggle="tooltip" data-original-title='.__('Mark Cancel').'">
                    <i class="fa fa-question-circle text-info"></i>
                </a>';
                    }
                    
                    return $actionBtn;
                })
            
                ->rawColumns(['action','status','title','order','name'])
                ->make(true);
                return view('shop.dashboardlist');
        }else{
            if (isset($_GET['views'])) {
                $typeview = $_GET['views'];
            } else {
                $typeview = null;
            }
            $shop_products = \App\ShopProduct::where('user_id', $user->id)->pluck('id')->toArray();
            $data = \App\ProductOrder::whereIn('product_id', $shop_products)->orWhere('user_id', $user->id)->orderBy("id", "desc")->paginate(5);
            if (!empty($data)) {
                foreach ($data as $row) {
                    $data->product_data = ShopProduct::where('id', $row->product_id)->first();
                }
            }
            $typeview = "active";
            return view('shop.dashboardlist', compact('typeview', 'data'));
        } 
    }

    public function orderList()
    {
        $user = Auth::user();
        $orders = \App\ProductOrder::select(
            [
                'product_orders.*',
                'users.name as user_name',
            ]
        )->join('users', 'product_orders.user_id', '=', 'users.id')->orderBy('product_orders.created_at', 'DESC')->where('users.id', '=', $user->id)->get();


        return view('shop.ordersList', compact('user', 'orders'));
    }

    public function index($view = 'list', Request $request)
    {
        $user = Auth::user();
        if ($request->ajax()) {  
            $data = ShopProduct::select('id','quantity','sku','image','title','special_price','tags','status','current_deal_off')->where("user_id", $user->id)->orderBy("id", "desc");
          
            switch ($request->filter_type) {
                case "Published":
                    $data->where('status', 'Published');
                    break;
                case "Unpublished":
                   $data->where('status', 'Unpublished');
                    break;
                case "stockout":
                  $data->where('stock_status', '!=',1);
                    break;
                case "instock":
                    $data->where('stock_status', 1);
                    break;
                case "free":
                    $data->where('price','<', 1);
                    break;
                
                default:
                    
                    break;
            }

          

            //keyword
            if (!empty($request->keyword)) {
                $data->WhereRaw('(title LIKE "%' . $request->keyword . '%" OR sku LIKE "%' . $request->keyword . '%" )');
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->filterColumn('sku', function($query, $keyword) use ($request) {
                    $query->orWhere('shopproducts.sku', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('shopproducts.title', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('shopproducts.special_price', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('shopproducts.tags', 'LIKE', '%' . $keyword . '%')
                   ;
                })
                ->addColumn('sku', function ($data) {
                    return $data->sku;

                 }) 
                 ->addColumn('title', function ($data) {
                    return $data->title .' ('.(!empty($data->special_price) ? format_price($data->special_price,2) : format_price($data->special_price,2)).')';
                 }) 
                  
             
                ->addColumn('status', function ($data) {
                   return  ' <span class="badge badge-sm badge-dot mr-4">
                   <i class="'.($data->status == 'Published').' ? "badge-success" : "badge-warning" "></i>
                   '. $data->status .'
               </span>  ';     
                }) 

                 ->addColumn('tags', function ($data) {
                    return  $data->quantity;
                  

                 })

                 ->addColumn('revenue', function ($data) {
                      
                   $rev= ShopProduct::find($data->id)->orders->where('product_id', $data->id)->sum("amount");
                    
                    return format_price($rev);

                 })



                //  ->addColumn('image', function ($data) {
                //     if(!empty($data->image)){
                //         if(file_exists(storage_path().'/shop/'.$data->image)){
                //          $url = asset('storage/shop/'.$data->image);
                //         }else{
                //             $url = asset('public/demo.png');
                //         }
                //     }else{
                //         $url = asset('public/demo.png');
                //     }
                //         return '<img onclick="profile_details('.$data->id.')" src="'.$url.'" class="avatar" width="50" height="50">'; 

                //     }) 

                ->addColumn('action', function($data){
                     $actionBtn = '<div class="actions text-right ">
           
                                                <a class="btn btn-sm bg-success-light mt-1" data-title="Edit " href="'. route('shop.edit',encrypted_key($data->id,'encrypt') ).'">
                                                    <i class="fas fa-pencil-alt"></i>
                                                    Edit
                                                </a>
                                                <a data-url="' . route('shop.destroy',encrypted_key($data->id,'encrypt')) . '" href="#" class="btn btn-sm bg-danger-light delete_record_model mt-1">
                                                    <i class="far fa-trash-alt"></i> Delete
                                                </a>
                                            </div>';
                    
                   
                return $actionBtn;
                
                })
                ->rawColumns(['action','tags','status'])
                ->make(true);
                return view('shop.index');
        }else{


        $title = "Shop Products";
        if (isset($_GET['view'])) {
            $view = 'list';
        }
        $authuser = $user;
        $title = "Shop";
        $data = ShopProduct::select('id','sku','image','title','special_price','tags')->where("user_id", $user->id)->orderBy("id", "desc")->get();

        foreach ($data as $row) {
            $row->revenue = ShopProduct::find($row->id)->orders->where('product_id', $row->id)->sum("amount");
            $row->sales = ShopProduct::find($row->id)->orders->where('product_id', $row->id)->count();
            $row->product_first_category = \App\ProductCategory::where('product_id', $row->id)->first();

            $shop_first_category = !empty($row->product_first_category->category_id) ? \App\ShopCategory::where("id", $row->product_first_category->category_id)->first() : '';
            $row->category_name = !empty($shop_first_category->name) ? $shop_first_category->name : 'Un-Categorized';

            $first_image = ShopProduct::find($row->id)->images->first();
            $row->image = !empty($first_image->img_url) ? $first_image->img_url : '';
          //  $row->stock_status = ShopProduct::stock_status($row->stock_status);
        }
        return view('shop.index', compact('view', 'title', 'data'));
        }
        

    }

    public function create()
    {
        $user = Auth::user();
        $title = "Create New Product";
        $data = new ShopProduct();
        $categories = ShopCategory::where('user_id', $user->id)->get();
        return view('shop.create_update_form', compact('categories', 'title', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Shop $serviceRequest
     * @return \Illuminate\Http\Response
     */
    public function edit($id_encrypted = 0)
    {
        $user = Auth::user();
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
  
//        if (!in_array("manage_shop", permissions()) && $user->type !="admin") {
//            return redirect()->back()->with('error', __('Permission Denied.'));
//        }
        if (!empty($id)) {
            $title = "Edit Shop Product";

            $product = ShopProduct::where("id", $id)->first();
            if (!empty($product->id)) {
                $specification = \App\ProductSpecification::where("product_id", $id)->get();
                $img_collection = \App\ProductImage::where("product_id", $id)->get();
                if (!empty($product->shipping_options)) {
                    $shipping_options = json_decode($product->shipping_options);
                } else {
                    $shipping_options = array();
                }
                $categories = ShopCategory::where('user_id', $user->id)->get();
                $productcategories = \App\ProductCategory::where("product_id", $id)->pluck('category_id')->toArray();

                $ids = [];
                $productAttributeOptions = \App\ProductOption::where("product_id", $id)->get();
                foreach ($productAttributeOptions as $key => $value) {
                    $productAttributeOptions[$key]->attribute_options_id = explode(",", $value->attribute_options_id);
                }
                $i = 0;
                $attributesIds = [];
                foreach ($productAttributeOptions as $key => $value) {
                    foreach ($value->attribute_options_id as $id) {
                        $attributesIds[$i] = $id;
                        $i++;
                    }
                }
                $categories = ShopCategory::where('user_id', $user->id)->get();
                return view('shop.create_update_form', compact('title', 'productcategories', 'categories', "product", "shipping_options", "img_collection", "specification", "attributesIds"));
            }
        }
        return redirect()->route('shop.index')->with('error', __('Permission Denied.'));
    }

    public function markshipped($id_encrypted = 0)
    {
        $user = Auth::user();
          
//        if (!in_array("manage_shop", permissions()) && $user->type !="admin") {
//            return redirect()->back()->with('error', __('Permission Denied.'));
//        }
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if (!empty($id)) {

            //for shop orders
            $shop_orders = \App\ProductOrder::with(['product' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }])->where('id', $id)->first();
            $shop_status['status'] = "Shipped";
            $shop_orders->update($shop_status);
            return redirect()->back()->with('success', __('Successfully updated.'));
        }

        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    public function markcancel($id_encrypted = 0)
    {
        $user = Auth::user();

        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
   
//        if (!in_array("manage_shop", permissions()) && $user->type !="admin") {
//            return redirect()->back()->with('error', __('Permission Denied.'));
//        }
        if (!empty($id) ) {

            //for shop orders
            $shop_orders = \App\ProductOrder::with(['product' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }])->where('id', $id)->first();
            $shop_status['status'] = "Cancelled";
            $shop_orders->update($shop_status);
            return redirect()->back()->with('success', __('Successfully updated.'));
        }

        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    public function preview($id_encrypted = 0)
    {
        $user = Auth::user();
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if (!empty($id)) {
            $title = "Product Details";

            $product = ShopProduct::where("id", $id)->first();
            if (!empty($product->id)) {
                $specification = \App\ProductSpecification::where("product_id", $id)->get();
                $img_collection = \App\ProductImage::where("product_id", $id)->get();
                if (!empty($product->shipping_options)) {
                    $shipping_options = json_decode($product->shipping_options);
                } else {
                    $shipping_options = array();
                }
                $productcategories = \App\ProductCategory::where("product_id", $id)->pluck('category_id')->toArray();

                $categories = ShopCategory::whereIn('id', $productcategories)->get();
                $ids = [];
                $productAttributeOptions = \App\ProductOption::where("product_id", $id)->get();
                foreach ($productAttributeOptions as $key => $value) {
                    $productAttributeOptions[$key]->attribute_options_id = explode(",", $value->attribute_options_id);
                }
                $i = 0;
                $attributesIds = [];
                foreach ($productAttributeOptions as $key => $value) {
                    foreach ($value->attribute_options_id as $id) {
                        $attributesIds[$i] = $id;
                        $i++;
                    }
                }
                return view('shop.preview', compact('title', 'productcategories', 'categories', "product", "shipping_options", "img_collection", "specification", "attributesIds"));
            }
        }
        return redirect()->route('shop.index')->with('error', __('Permission Denied.'));
    }

    public function placeorder(Request $request)
    {
        $user = Auth::user();
        $title = "Payment Details";
        $id = !empty($request->id) ? encrypted_key($request->id, 'decrypt') : 0;
        if (!empty($id)) {

            $product = ShopProduct::where("id", $id)->first();
            $quantity = !empty($request->quantity) ? $request->quantity : 1;

            return view('shop.payment', compact('title', 'product', 'quantity'));
        }
        return redirect()->route('shop.index')->with('error', __('Permission Denied.'));
    }

    //quickly buy from addon
    public function quickbuy($id_encrypted = 0)
    {
        $user = Auth::user();
        $title = "Payment Details";
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if (!empty($id)) {

            $product = ShopProduct::where("id", $id)->first();
            $quantity = !empty($request->quantity) ? $request->quantity : 1;

            return view('shop.quick_buy', compact('title', 'product', 'quantity'));
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    public function productdeleteimg(Request $request)
    {
        $product = \App\ProductImage::where('id', $request->id)->first();
        if (!empty($product->img_url)) {
            File::delete($product->img_url, "shop");
        }
        $data = \App\ProductImage::where('id', $request->id)->delete();
        if ($data) {
            return "1";
        } else {
            return "0";
        }
    }

    public function getcategory()
    {
        $user = Auth::user();
        $categories = ShopCategory::get();
        return $categories;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
          
//        if (!in_array("manage_shop", permissions()) && $user->type !="admin") {
//            return redirect()->back()->with('error', __('Permission Denied.'));
//        }
        if (!empty($user->type) ) {
            $validation = [
                'title' => 'required|max:500|min:5',
                'sku' => 'required|max:50',
                'tags' => 'required|max:500',
                'refund_disclaimer' => 'required|max:1000'
            ];
            $validator = Validator::make(
                $request->all(), $validation
            );
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            //fetching product images
            $imagename = '';
            if (!empty($request->image)) {
                $base64_encode = $request->image;
                $folderPath = "storage/shop/";
                File::isDirectory($folderPath) or File::makeDirectory($folderPath, 0777, true, true);
                //Storage::disk('local')->makeDirectory('shop');
                $image_parts = explode(";base64,", $base64_encode);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $image = "product" . uniqid() . '.' . $image_type;;
                $file = $folderPath . $image;
                file_put_contents($file, $image_base64);
                $imagename = $image;
//
//
//                foreach ($request->image as $image) {
//                    if (!empty($image)) {
//                        $fileName = 'product' . time() . "_" . $image->getClientOriginalName();
//
//                        $image->storeAs('shop', $fileName);
//
//                        $imageNames[] = $fileName;
//                    }
//                }
            }


            $product_id = !empty($request->id) ? encrypted_key($request->id, 'decrypt') : 0;
            if (!empty($product_id)) {
                //update existing product
                $shopproductUpdate = ShopProduct::where('id', $product_id)->where('user_id', $user->id)->first();
                $shopproduct['title'] = trim($request->title);
                $shopproduct['sku'] = trim($request->sku);
                $shopproduct['status'] = trim($request->status);
                $shopproduct['price'] = trim($request->price);
                $shopproduct['special_price'] = trim($request->special_price);
//                $shopproduct['commision_points'] = trim($request->commision_points);
                $shopproduct['quantity'] = trim($request->quantity);
                $shopproduct['stock_status'] = trim($request->stock_status);
                $shopproduct['type'] = trim($request->type);
                $shopproduct['category_id'] = trim($request->category_id);
                $shopproduct['current_deal_off'] = trim($request->current_deal_off);
                $shopproduct['tags'] = trim($request->tags);
                $shopproduct['description'] = trim($request->description);
                $shopproduct['vendor'] = trim($request->vendor);
                $shopproduct['refund_disclaimer'] = trim($request->refund_disclaimer);
                $shopproduct['shipping_options'] = json_encode($request->shipping_options);
                $shopproduct['brand'] = trim($request->brand);
                $shopproduct['faqs'] = trim($request->faqs);
                $shopproductUpdate->update($shopproduct);
                $is_updated = 1;
            } else {
                //insert new product
                $shopproduct = new ShopProduct();
                $shopproduct['user_id'] = $user->id;
                $shopproduct['title'] = trim($request->title);
                $shopproduct['sku'] = trim($request->sku);
                $shopproduct['status'] = trim($request->status);
                $shopproduct['price'] = trim($request->price);
                $shopproduct['special_price'] = trim($request->special_price);
//                $shopproduct['commision_points'] = trim($request->commision_points);
                $shopproduct['quantity'] = trim($request->quantity);
                $shopproduct['stock_status'] = trim($request->stock_status);
                $shopproduct['type'] = trim($request->type);
                $shopproduct['category_id'] = trim($request->category_id);
                $shopproduct['current_deal_off'] = trim($request->current_deal_off);
                $shopproduct['tags'] = trim($request->tags);
                $shopproduct['description'] = trim($request->description);
                $shopproduct['vendor'] = trim($request->vendor);
                $shopproduct['refund_disclaimer'] = trim($request->refund_disclaimer);
                $shopproduct['shipping_options'] = json_encode($request->shipping_options);
                $shopproduct['brand'] = trim($request->brand);
                $shopproduct['faqs'] = trim($request->faqs);
                $shopproduct->save();

                if ($shopproduct->id) {
                    $product_id = $shopproduct->id;
                } else {
                    $product_id = 0;
                }
            }


            //saving product attribures
            \App\ProductOption::where("product_id", $product_id)->delete();
            if (!empty($request->productAttributes)) {
                foreach ($request->productAttributes as $key => $value) {
                    $optionsId = implode(",", $value);
                    $productoptions = new \App\ProductOption();
                    $productoptions['product_id'] = $product_id;
                    $productoptions['attribute_id'] = $key;
                    $productoptions['attribute_options_id'] = $optionsId;
                    $productoptions->save();
                }
            }


            //udpating product categories
            \App\ProductCategory::where("product_id", $product_id)->delete();
            $productcategories = new \App\ProductCategory();
            $productcategories['product_id'] = $product_id;
            $productcategories['category_id'] = $request->category;
            $productcategories->save();


            //updating product images
            if (!empty($imagename)) {
//                foreach ($imageNames as $key => $value) {
                $productimages = new \App\ProductImage();
                $productimages['product_id'] = $product_id;
                $productimages['img_url'] = $imagename;
                $productimages->save();
//                }
            }

            //updating product specifications
            \App\ProductSpecification::where("product_id", $product_id)->delete();
            $inputfields = $request->fieldtitle;
            $fielddatavalue = $request->value;
            if (!empty($inputfields)) {
                foreach ($inputfields as $key => $value) {
                    $productspecifications = new \App\ProductSpecification();
                    $productspecifications['product_id'] = $product_id;
                    $productspecifications['title'] = $value;
                    $productspecifications['value'] = $fielddatavalue[$key];
                    $productspecifications->save();
                }
            }

            if (!empty($is_updated)) {
                return redirect()->back()->with('success', __('Product updated successfully.'));
            } else {
                return redirect()->route('shop.index')->with('success', __('Product added successfully.'));
            }
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    public function view($view = 'grid')
    {
        $user = Auth::user();
        $authuser = $user;
        $title = "Shop";
        $data = ShopProduct::where("user_id", $user->id)->orderBy("id", "desc")->paginate(6);

        foreach ($data as $row) {
            $row->revenue = ShopProduct::find($row->id)->orders->where('product_id', $row->id)->sum("amount");
            $row->sales = ShopProduct::find($row->id)->orders->where('product_id', $row->id)->count();
            $row->product_first_category = \App\ProductCategory::where('product_id', $row->id)->first();

            $shop_first_category = !empty($row->product_first_category->category_id) ? \App\ShopCategory::where("id", $row->product_first_category->category_id)->first() : '';
            $row->category_name = !empty($shop_first_category->name) ? $shop_first_category->name : 'Un-Categorized';

            $first_image = ShopProduct::find($row->id)->images->first();
            $row->image = !empty($first_image->img_url) ? $first_image->img_url : '';
            $row->stock_status = ShopProduct::stock_status($row->stock_status);
        }

        if (isset($_GET['view'])) {
            $view = 'list';
            $returnHTML = view('shop.list', compact('view', 'data', 'title'))->render();
        } else {

            $returnHTML = view('shop.grid', compact('view', 'data', 'title'))->render();
        }

        return response()->json(
            [
                'success' => true,
                'html' => $returnHTML,
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Shop $serviceRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy($id=0)
    {
        $user = Auth::user();
        $id =  !empty($id) ? encrypted_key($id, 'decrypt') : 0;
        if (!empty($id)) {
            $data = ShopProduct::where('id', $id)->where('user_id', $user->id)->first();
            if (!empty($data->id)) {
                $data->delete();

                \App\ProductOption::where("product_id", $id)->delete();
                \App\ProductCategory::where("product_id", $id)->delete();
                \App\ProductSpecification::where("product_id", $id)->delete();
                $product = \App\ProductImage::where('id', $id)->first();
                if (!empty($product->img_url)) {
                    File::delete($product->img_url, "shop");
                }
                $data = \App\ProductImage::where('id', $id)->delete();
                return redirect()->back()->with('success', __('Product and all data deleted successfully.'));
            }
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }

    
    
     public function shop(Request $request)
    {
        $user = Auth::user();
        $domain_user= get_domain_user();
        if($request->ajax()){
            
         
        $date = date('yy-m-d h:m:s');

        $build_query = \App\ShopProduct::where('status', "Published")
            ->where('quantity', '>', 0);

        if (!empty($domain_user)) {
            $build_query->whereIn('user_id', [$domain_user->id,1]);
        }

        if (!empty($request->search)) {
            $build_query->where('title', 'LIKE', '%' . $request->search . '%');
            
        }

        if (!empty($request->category) && $request->category != 'All') {
             $shop_products_array = \App\ProductCategory::where('category_id', $request->category)->pluck('product_id')->toArray();
            $build_query->whereIn('id', $shop_products_array);
            
        }

            switch ($request->sortby) {
                case 'average_rating':
                    $build_query->orderBy('rating', 'DESC');
                    break;
                case 'low':
                    $build_query->orderBy('special_price', 'ASC');
                    break;
                case 'high':
                    $build_query->orderBy('special_price', 'DESC');
                    break;
                default:
                    $build_query->orderBy('id', 'DESC');
            }
     
        if (!empty($request->min_amount)) {
            $build_query->where('price', ">=", $request->min_amount);
        }
        if (!empty($request->max_amount)) {
            $build_query->where('price', "<=", $request->max_amount);
            $build_query->orwhere('special_price', "<=", $request->max_amount);
        }

        if (isset($request->time)) {
            $time = $request->time;
        } else {
            $time = '';
        }
        if (!empty($time)) {
            if (in_array('onemonth', $time)) {
                $timeFormatted = date('yy-m-d h:m:s', strtotime('-1 months', strtotime($date)));
            } elseif (in_array('fourteenday', $time)) {
                $timeFormatted = date('yy-m-d h:m:s', strtotime('-14 days', strtotime($date)));
            } elseif (in_array('sevenday', $time)) {
                $timeFormatted = date('yy-m-d h:m:s', strtotime('-7 days', strtotime($date)));
            } elseif (in_array('oneday', $time)) {
                $timeFormatted = date('yy-m-d h:m:s', strtotime('-1 days', strtotime($date)));
            } elseif (in_array('lasthour', $time)) {
                $timeFormatted = date('yy-m-d h:m:s', strtotime('-1 hours', strtotime($date)));
            }
        }
        if (!empty($timeFormatted)) {
            $build_query->where('created_at', '>=', $timeFormatted);
        }


        $data = $build_query->paginate(8);

        if (!empty($request->view) && $request->view == 'list') {
            return view('shop.shopping.FilterList', compact('data'));
        } else {
            return view('shop.shopping.FilterGrid', compact('data'));
        }
   
        }else{
        
    $categories = ShopCategory::whereIn('user_id', [$domain_user->id,1])->get();
            return view('shop.shopping.index', compact('categories'));
        }
    
    }
     public function productquickview(Request $request) {
        $id = $request->id ?? 0;
        if (!empty($id)) {
            $row = \App\ShopProduct::where("id", $id)->first();
            if (!empty($row->id)) {
                return view('shop.shopping.quickview', compact("row"));
            }
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }
    public function product_add_cart(Request $request) {
        $id = $request->id ?? 0;
        $type = $request->type ?? '';
        $param = $request->param ?? '';
      
        switch ($type){
            case "remove":
                LaraCart::removeItem($param);
                break;
            case "quantityupdate":
                LaraCart::updateItem($id, 'qty',$param);      
                break;
            default:
        $product = \App\ShopProduct::where("id", $id)->first();
     $data1 = LaraCart::getItems();
     $quty=0;
     if(!empty($data1)){
         foreach ($data1 as $row){
             if($row->id==$id){
                 $quty=$row->qty;
             }
         }
     }
        if (!empty($product) && $product->stock_status==1 && !empty($product->quantity) && $quty < $product->quantity) {
            LaraCart::add(
               $product->id, //uniqid(),  inique row ID
               $product->title,
              1,
              !empty($product->special_price) ? $product->special_price : $product->price,
              array(
                  'user_id'=>$product->user_id,
                 // 'current_deal_off'=>$product->current_deal_off
                  )
            );
        }
        
        }
       //   LaraCart::emptyCart();
        $data = LaraCart::getItems();
     
        $subtotal = LaraCart::subTotal($format = true, $withDiscount = true);
        
       $returnHTML=view('shop.shopping.HeaderCartItems', compact("data","subtotal"))->render();
       
       $qty1=0;
        if(!empty($data)){
         foreach ($data as $row){
            
                 $qty1=$row->qty;
           
         }
     }
       $returnCount=$qty1??0;
    
        return response()->json( array(
            "html"=>$returnHTML,
            "count"=>$returnCount
            ));
    }
    public function productscart() {
        $data = LaraCart::getItems();
        $billdetails=array();
        $deal_discount=0;
        foreach ($data as $i=>$row){
            $deal=0;
           $billdetails[$i]['id']=$row->id;
           $billdetails[$i]['name']=$row->name;
           $billdetails[$i]['qty']=$row->qty;
           $billdetails[$i]['price']=$row->price;
           $billdetails[$i]['subtotal']=$row->subTotal(false);
           $billdetails[$i]['user_id']=$row->user_id;
//           if(!empty($row->current_deal_off)){
//               $deal=$row->current_deal_off*.01*$row->price*$row->qty;
//               $deal_discount=$deal_discount+$deal;
//           }
           $billdetails[$i]['deal']=$deal;
        }
//        if(!empty($deal_discount)){
//            $marketplace = \App\WebsiteSetting::WebsiteSetting('marketplace',1);
//
//                                  if(!empty($marketplace->value)){
//                                       $marketplace  = json_decode($marketplace->value,true);
//                                  }else{
//                                      $marketplace = array();
//                                  }
//                                  $deal_datetime=!empty($marketplace['marketplace_home_deal_datetime']) ? date('Y-m-d H:i:s', strtotime($marketplace['marketplace_home_deal_datetime'])):'';
//                              
//                                if(Carbon::now()->toDateTimeString() < $deal_datetime){
//            LaraCart::addFee(($marketplace['marketplace_home_deal_name'] ?? 'Deal of the day'), -$deal_discount, $taxable =  false, $options = []);
//                                }
//        }
        $discount_details = LaraCart::getFees();
      
         $subtotal_without_discount = LaraCart::subTotal($format = true);
         $subtotal_with_discount = LaraCart::subTotal($format = true, $withDiscount = true);
      
         $total = LaraCart::total($formatted = true, $withDiscount = true);
        return view('shop.shopping.cart', compact("billdetails","data","total","discount_details","subtotal_with_discount","subtotal_without_discount"));
    }
    
    public function productscheckout() {
        $user = Auth::user();
 $data = LaraCart::getItems();
  if(empty($data)){
     return redirect()->route('shop')->with('error', __('First add products in cart'));
 }
        $billdetails=array();
        $deal_discount=0;
        foreach ($data as $i=>$row){
            $deal=0;
           $billdetails[$i]['id']=$row->id;
           $billdetails[$i]['name']=$row->name;
           $billdetails[$i]['qty']=$row->qty;
           $billdetails[$i]['price']=$row->price;
           $billdetails[$i]['subtotal']=$row->subTotal(false);
           $billdetails[$i]['user_id']=$row->user_id;
//           if(!empty($row->current_deal_off)){
//               $deal=$row->current_deal_off*.01*$row->price*$row->qty;
//               $deal_discount=$deal_discount+$deal;
//           }
           $billdetails[$i]['deal']=$deal;
        }
//        if(!empty($deal_discount)){
//            $marketplace = \App\WebsiteSetting::WebsiteSetting('marketplace',1);
//
//                                  if(!empty($marketplace->value)){
//                                       $marketplace  = json_decode($marketplace->value,true);
//                                  }else{
//                                      $marketplace = array();
//                                  }
//                                  $deal_datetime=!empty($marketplace['marketplace_home_deal_datetime']) ? date('Y-m-d H:i:s', strtotime($marketplace['marketplace_home_deal_datetime'])):'';
//                              
//                                if(Carbon::now()->toDateTimeString() < $deal_datetime){
//            LaraCart::addFee(($marketplace['marketplace_home_deal_name'] ?? 'Deal of the day'), -$deal_discount, $taxable =  false, $options = []);
//                                }
//        }
        $discount_details = LaraCart::getFees();
      
         $subtotal_without_discount = LaraCart::subTotal($format = true);
         $subtotal_with_discount = LaraCart::subTotal($format = true, $withDiscount = true);
      
         $total = LaraCart::total($formatted = true, $withDiscount = true);         
         
         
         
        return view('shop.shopping.checkout', compact("billdetails","data","total","discount_details","subtotal_with_discount","subtotal_without_discount"));
        
    }
    
    public function productspayment(Request $request) {
        $user = Auth::user();
 $data = LaraCart::getItems();
 if(empty($data)){
     return redirect()->route('shop')->with('error', __('First add products in cart'));
 }
   $stripe_settings=\App\SiteSettings::getValByName('payment_settings');
               
        if (!empty($stripe_settings['STRIPE_KEY']) && !empty($stripe_settings['STRIPE_SECRET']) && $stripe_settings['ENABLE_STRIPE']=="on") {
            $stripe_key=$stripe_settings['STRIPE_KEY'];
        } else {
            return redirect()->back()->with('error', __('Stripe not enabled.'));
        }
        $billdetails=array();
        $deal_discount=0;
        foreach ($data as $i=>$row){
            $deal=0;
           $billdetails[$i]['id']=$row->id;
           $billdetails[$i]['name']=$row->name;
           $billdetails[$i]['qty']=$row->qty;
           $billdetails[$i]['price']=$row->price;
           $billdetails[$i]['subtotal']=$row->subTotal(false);
           $billdetails[$i]['user_id']=$row->user_id;
//           if(!empty($row->current_deal_off)){
//               $deal=$row->current_deal_off*.01*$row->price*$row->qty;
//               $deal_discount=$deal_discount+$deal;
//           }
           $billdetails[$i]['deal']=$deal;
        }
//        if(!empty($deal_discount)){
//            $marketplace = \App\WebsiteSetting::WebsiteSetting('marketplace',1);
//
//                                  if(!empty($marketplace->value)){
//                                       $marketplace  = json_decode($marketplace->value,true);
//                                  }else{
//                                      $marketplace = array();
//                                  }
//                                  $deal_datetime=!empty($marketplace['marketplace_home_deal_datetime']) ? date('Y-m-d H:i:s', strtotime($marketplace['marketplace_home_deal_datetime'])):'';
//                              
//                                if(Carbon::now()->toDateTimeString() < $deal_datetime){
//            LaraCart::addFee(($marketplace['marketplace_home_deal_name'] ?? 'Deal of the day'), -$deal_discount, $taxable =  false, $options = []);
//                                }
//        }
        $discount_details = LaraCart::getFees();
      
         $subtotal_without_discount = LaraCart::subTotal($format = true);
         $subtotal_with_discount = LaraCart::subTotal($format = true, $withDiscount = true);
      
         $total = LaraCart::total($formatted = true, $withDiscount = true);
         
         $order_note=$request->order_note??'';
         $purchaser=\App\User::find($request->user??'');
         if(empty($purchaser)){
              return redirect()->back()->with('error', __('Purchaser empty.'));
         }
          return view('shop.shopping.payment', compact('purchaser','stripe_key',"order_note","billdetails","data","total","discount_details","subtotal_with_discount","subtotal_without_discount"));
    }
    
    public function productdetails($id_encrypted = 0) {
        $user = Auth::user();
        $id = !empty($id_encrypted) ? encrypted_key($id_encrypted, 'decrypt') : 0;
        if (!empty($id)) {
            $product = \App\ShopProduct::where("id", $id)->first();

            //setting visit cookies
//            $ProductsSeen = !empty($_COOKIE['ProductsSeen']) ? explode(',', $_COOKIE['ProductsSeen']) : array();
//            array_push($ProductsSeen, $id);
//            setcookie('ProductsSeen', implode(',', $ProductsSeen), time() + (6 * 30 * 24 * 3600), "/"); // 86400 = 1
//            if (empty($_COOKIE['ProductsSeen'])) {
//                setcookie('ProductsSeen', implode(',', $ProductsSeen), time() + (6 * 30 * 24 * 3600), "/"); // 86400 = 1
//            }

            if (!empty($product->id)) {
                $specification = \App\ProductSpecification::where("product_id", $id)->get();
                $img_collection = \App\ProductImage::where("product_id", $id)->get();
                if (!empty($product->shipping_options)) {
                    $shipping_options = json_decode($product->shipping_options);
                } else {
                    $shipping_options = array();
                }
                $productcategories = \App\ProductCategory::where("product_id", $id)->pluck('category_id')->toArray();
                $categories = \App\ShopCategory::whereIn('id', $productcategories)->get();
                $reviews = \App\ShopProductRating::where('product_id', $id)->get();
                $user_rating = \App\ShopProductRating::where("user_id", $user->id ?? 0)->where("product_id", $id)->first();
                return view('shop.shopping.details', compact("user_rating", 'productcategories', 'categories', "product", "shipping_options", "img_collection", "specification", "reviews"));
            }
        }
        return redirect()->back()->with('error', __('Permission Denied.'));
    }
    public function productreviewpost(Request $request) {
        
        $user = Auth::user();
        $success = 'error';
        $message = "Please login first to submit review.";
        if (!empty($request->rating) && !empty($request->review) && !empty($request->product)) {
            if (!empty($user->id)) {
                $user_rating = \App\ShopProductRating::where("user_id", $user->id)->where("product_id", $request->product)->first();
                if (empty($user_rating)) {
                    $rating = new \App\ShopProductRating();
                    $rating['user_id'] = $user->id;
                    $rating['product_id'] = $request->product;
                    $rating['rating'] = $request->rating;
                    $rating['comment'] = $request->review;
                    $rating->save();

                    $product_avg_rating = \App\ShopProductRating::where("product_id", $request->product)->avg('rating');
                    $product_details = \App\ShopProduct::find($request->product);
                    $product_details->rating = $product_avg_rating;
                    $product_details->save();
                    $message = "Successfully submitted";
                } else {

                    $message = "You have already submitted review";
                }
                $success = 'success';
            }
        } else {
            $message = "Please fill required fields";
        }
           return redirect()->back()->with($success, __($message));
    }
}
