<form method="POST" action="{{ route('wallet.transfer.post')}}" accept-charset="UTF-8" id="withdraww" enctype="multipart/form-data">
    @csrf
        @php
        $user=Auth::user();
        $permissions=permissions();
        @endphp
    <p class="text-warning">Extra $1.00 will be charged as network fee for this transaction.</p><p>
    </p>
    <div class="form-group">
        <!--<h2>Via Stripe</h2>-->
        <div class="row">
            <div class="col-md-12">
                <label>Enter Amount</label>
                <input type="number" class="form-control" min="1" step="1" name="amount" value="" id="myInputt" placeholder="Entered amount should not be greater than {{format_price($user->wallet_balance,2)}}" required="">
            </div>
        </div>
    </div>

    <div class="form-group">
        <!--<h2>Via Stripe</h2>-->
        <div class="row">
            <div class="col-md-12">
                <label>Receiver Wallet Name</label>
                <select name="destination" id="destination" class="form-control" style="width: 100%">
                    @if(!empty($walletuser))
                    @foreach($walletuser as $_walletuser)

                    <option value="{{$_walletuser->id}}">{{$_walletuser->name}}, {{$_walletuser->type}} ({{$_walletuser->email}})</option>

                    @endforeach
                    @endif

                </select>
            </div>
        </div>
    </div>


    <div class="text-right">
        <!--<button type="submit" class="btn btn-sm btn-primary rounded-pill">Save</button>-->
        <button type="button" class="btn  btn-primary rounded-pill" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn  btn-danger rounded-pill">Transfer</button>
    </div>
</form>

<script>

    $(document).ready(function() {
    $('#destination').select2();
});
</script>