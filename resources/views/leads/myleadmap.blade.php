<?php $page = "book"; ?>
@extends('layout.dashboardlayout')
@section('content')	
<style>
.view-icons {
    margin: 20px 0;
}

.view-icons a {
    align-items: center;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    color: #212529;
    display: flex;
    font-size: 17px;
    justify-content: center;
    padding: 4px 8px;
    text-align: center;
    margin-left: 10px;
    width: 37px;
    height: 37px;
}


        
        .mapael .map {
            position: relative;
        }

        .mapael .mapTooltip {
            position: absolute;
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            z-index: 1000;
            max-width: 200px;
            display: none;
            color: #343434;
        }
        
    </style>
</style>
<!-- Page Content -->
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
            <!-- Sidebar -->
            @include('layout.partials.userSideMenu')
            <!-- /Sidebar -->
         </div>
         <div class="col-md-7 col-lg-8 col-xl-9">
         <a href="{{ url()->previous() }}" id="back" class="btn btn-sm btn-primary float-right ml-2">
                  <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
             </a>
            <!-- Breadcrumb -->
            <div class="breadcrumb-bar mt-3">
               <div class="container-fluid">
                  <div class="row align-items-center">
                     <div class="col-md-12 col-12">
                        <h2 class="breadcrumb-title">Leads profile</h2>
                        <nav aria-label="breadcrumb" class="page-breadcrumb">
                           <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="index">Home</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Lead</li>
                           </ol>
                        </nav>
                     </div>
                  </div>
               </div>
            </div>
            <!-- /Breadcrumb -->
            <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="view-icons">
                <a href="@php echo url( 'my-lead').'/'.$name.'/'.$id.'/user'; @endphp" class="grid-view"><i class="fas fa-bars"></i></a>
                <a href="@php echo url( 'my-lead').'/'.$name.'/'.$id.'/user'; @endphp/grid-view" class="grid-view"><i class="fas fa-th-large"></i></a>
                <a href="@php echo url( 'my-lead').'/'.$name.'/'.$id.'/user'; @endphp/map-view" class="list-view active"><i class="fas fa-map"></i></a>
            </div>
               <div class="card">
                       <!-- data -->
                   
                        <div class="mapcontainer">
                           <div class="map">
                                 <span>Loading..</span>
                           </div>
                        </div>
                        <!-- data -->
             
              </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- /Page Content -->
@endsection
@push('script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"
            charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.2.7/raphael.min.js" charset="utf-8"></script>
    <script src="{{ asset('public/assets/js/jquery.mapael.js') }}" charset="utf-8"></script>
    <script src="{{ asset('public/assets/js/maps/france_departments.js') }}" charset="utf-8"></script>
    <script src="{{ asset('public/assets/js/maps/world_countries.js') }}" charset="utf-8"></script>
    <script src="{{ asset('public/assets/js/maps/usa_states.js') }}" charset="utf-8"></script>
    

    <script type="text/javascript">
        $(function () {

            var test_plots = @php print_r( $data ); @endphp;

            var getElemID = function(elem) {
                // Show element ID
                return $(elem.node).attr("data-id");
            };

            $(".mapcontainer").mapael({
                map: {
                    // Set the name of the map to display
                    name: "usa_states",
                    backgroundColor:'#ffffff',
                   color:'#ffffff',
                   hoverOpacity: 0.7,
                  selectedColor:'#ffffff',
              
                }, 
                defaultPlot: {
        type: "circle",
        size: 15,
        attrs: {
            fill: "#0088db",
            stroke: "#fff",
            "stroke-width": 0,
            "stroke-linejoin": "round"
        },
        attrsHover: {
            "stroke-width": 1,
            animDuration: 2000,
            transform: "s1.5"
        },
        text: {
            position: "right",
            margin: 5,
            attrs: {
                "font-size": 25,
                fill: "#c7c7c7"
            },
            attrsHover: {
                fill: "#eaeaea",
                animDuration: 300
            }
        },
        target: "_self"
    },
    
    areas: {
  "AL": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Alabama</span>"
    }
  },
  "NY": {
    "value": "50586757",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">New York </span><br />"
    }
  },
  "AL": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Alabama</span>"
    }
  },
   "AK": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Alaska</span>"
    }
  },
  "AZ": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Arizona</span>"
    }
  },
  "AR": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Arkansas</span>"
    }
  },
  "CA": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">California</span>"
    }
  },
  "CO": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Colorado</span>"
    }
  },
  "CT": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Connecticut</span>"
    }
  },
  "DE": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Delaware</span>"
    }
  },
  "DC": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">District of Columbia</span>"
    }
  },
  "FL": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Florida</span>"
    }
  },
  "GA": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Georgia</span>"
    }
  },
  "HI": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Hawaii</span>"
    }
  },
  "ID": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Idaho</span>"
    }
  },
  "IL": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Illinois</span>"
    }
  },
  "IN": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Indiana</span>"
    }
  },
  "IA": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Iowa</span>"
    }
  },
  "KS": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Kansas</span>"
    }
  },
  "KY": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Kentucky</span>"
    }
  },
  "LA": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Louisiana</span>"
    }
  },
  "ME": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Maine</span>"
    }
  },
  "MD": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Maryland</span>"
    }
  },
  "MA": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Massachusetts</span>"
    }
  },
  "MI": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Michigan</span>"
    }
  },
  "MN": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Minnesota</span>"
    }
  },
  "MS": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Mississippi</span>"
    }
  },
  "MO": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Missouri</span>"
    }
  },
  "MT": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Montana</span>"
    }
  },
  "NE": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Nebraska</span>"
    }
  },
  "NV": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Nevada</span>"
    }
  },
  "NH": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">New Hampshire</span>"
    }
  },
  "NJ": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">New Jersey</span>"
    }
  },
  "NM": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">New Mexico</span>"
    }
  },
  "NY": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">New York</span>"
    }
  },
  "NC": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">North Carolina</span>"
    }
  },
  "ND": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">North Dakota</span>"
    }
  },
  "OH": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Ohio</span>"
    }
  },
  "OK": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Oklahoma</span>"
    }
  },
  "OR": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Oregon</span>"
    }
  },
  "PA": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Pennsylvania</span>"
    }
  },
  "RI": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Rhode Island</span>"
    }
  },
  "SC": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">South Carolina</span>"
    }
  },
  "SD": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">South Dakota</span>"
    }
  },
  "TN": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Tennessee</span>"
    }
  },
  "TX": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Texas</span>"
    }
  },
  "UT": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Utah</span>"
    }
  },
  "VT": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Vermont</span>"
    }
  },
  "VA": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Virginia</span>"
    }
  },
  "WA": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Washington</span>"
    }
  },
  "WV": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">West Virginia</span>"
    }
  },
  "WI": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Wisconsin</span>"
    }
  },
  "WY": {
    "value": "35320445",
    "attrs": {
      "href": "#",
      fill: "{{ $color }}"
    },
    "tooltip": {
      "content": "<span style=\"font-weight:bold;\">Wyoming</span>"
    }
  },
},
                   plots: test_plots
            });
        });
    </script>
@endpush