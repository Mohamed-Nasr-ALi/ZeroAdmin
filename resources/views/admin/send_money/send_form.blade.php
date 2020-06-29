<!-- Material form contact -->
<div class="card">

    <h5 class="card-header info-color white-text text-center py-4">
        <strong>Add Money(Top Up)</strong>
    </h5>
<form class="p-3" action="{{route('send_money_transaction')}}" method="POST" autocomplete="off">
    @csrf
    <input type="hidden" value="1" name="admin_id">
    <div class="md-form form-lg">
        <i class="fas fa-hand-holding-usd prefix"></i>
        <input maxlength="20" value="{{old('amount')}}"  name="amount" type="text" id="inputLGEx" class="form-control form-control-lg">
        <label for="inputLGEx">Amount</label>
        @if($errors->has('amount'))
            <span class="text-danger">{{ $errors->first('amount')}} </span>
        @endif
    </div>
    <div class="input-group mb-3">
        <select name="" id="paises" class="form-control"></select>
        <div class="input-group-prepend">
            <span class="input-group-text telefono" id="inputGroup-sizing-default"> &nbsp; &nbsp;</span>
        </div>
        <input id="phone_number" value="{{old('phone_number')}}" maxlength="20" name="phone_number" type="text" class="form-control"  placeholder="Phone Number EX: 11000101011">
    </div>
    @if($errors->has('phone_number'))
        <span class="text-danger"> {{ $errors->first('phone_number')}}</span>
    @endif
    <div class="md-form form-lg">
        <i class="fas fa-lock prefix"></i>
        <input minlength="4" maxlength="4" name="pin" type="password" id="inputLGEx2" class="form-control form-control-lg">
        <label for="inputLGEx2" data-error="wrong" data-success="right">Type your PIN (PIN is: 1234 as default)</label>
        @if($errors->has('pin'))
            <span class="text-danger">{{ $errors->first('pin')}}</span>
        @endif
        @if($errors->has('admin_id'))
            <span class="text-danger">don't try this</span>
        @endif
    </div>

    <button id="submit_button" type="submit" class="btn btn-primary"><i class="fas fa-magic mr-1"></i> Submit</button>
</form>
</div>
