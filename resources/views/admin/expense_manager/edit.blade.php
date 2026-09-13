@php
    $expense_details= DB::table('expense_managers')->where('id', $id)->first();
	$expense_categories = DB::table('expense_categories')->get();
    $user = App\Models\User::orderBy('id', 'desc')->get();
@endphp

<form action="{{route('admin.exp.manager.update',['id'=>$id])}}" method="post" enctype="multipart/form-data">
@Csrf
	<div class="fpb-7">
		<label for="title" class="eForm-label">{{get_phrase('Title')}}</label>
		<input type="text" name="title" class="form-control eForm-control" id="title" value="{{ $expense_details->title }}" required>
	</div>
	<div class="fpb-7">
		<label for="expense_category" class="eForm-label">{{get_phrase('Expense Category')}}</label>
        <select class="form-select eForm-select select2" id="expense_category" name="expense_category">
       	<option>{{ get_phrase('Select a category') }}</option>
        @foreach($expense_categories as $row)
        <option value="{{$row->id}}" @if($row->id == $expense_details->expense_category) selected @endif>{{$row->name}}</option>
        @endforeach
        </select>
    </div>
	<div class="fpb-7">
		<label for="amount" class="eForm-label">{{get_phrase('Amount')}}</label>
		<input type="number" name="amount" class="form-control eForm-control" id="amount" value="{{ $expense_details->amount }}" required>
	</div>

	<div class="fpb-7">
		<label for="user_id" class="eForm-label">{{get_phrase('User')}}</label>
        <select class="form-select eForm-select select2" id="user_id" name="user_id">
       	<option>{{ get_phrase('Select an user') }}</option>
        @foreach($user as $row)
        <option value="{{$row->id}}" @if($row->id == $expense_details->user_id) selected @endif>{{$row->name}}</option>
        @endforeach
        </select>
    </div>
	<div class="fpb-7">
		<label for="note" class="eForm-label">{{get_phrase('Note')}}</label>
		<input type="text" name="note" class="form-control eForm-control" id="note"  value="{{ $expense_details->note }}">
	</div>

	<div class="fpb-7">
        <label for="date" class="eForm-label">{{get_phrase('Date')}}</label>
        <input type="date" class="form-control eForm-control inputDate" id="date" name="date" value="{{ $expense_details->date }}" required="">
    </div>
	<button type="submit" class="btn-form mt-2 mb-3">{{get_phrase('Create Expense')}}</button>
</form>

@include('init')
