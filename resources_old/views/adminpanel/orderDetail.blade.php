@extends('adminpanel.cirrb')

@section('page-title')
	Order ID #{{ $order->id }}
@endsection

@section('content')

  <h4>Restaurant : {{ $order->restaurant_name }}</h4>
  <h4>Branch : {{ $order->branch_name }}</h4>

  <div class="clearfix"></div>
  <div class="table-box">
    <table class="table table-bordered">
    <thead>
      <tr>
        <th>Itmes</th>
        <th>Quantity</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>

      @foreach( $order->order_list as $orderlist )

        <tr>
          <td>{{ $orderlist->name }}</td>
          <td>{{ $orderlist->quantity }}</td>
          <td>SR {{ $orderlist->cost }}</td>
        </tr>

      @endforeach
      <tr>
        <td></td>
        <td><strong>Sub Total</strong></td>
        <td>SR {{ $order->sub_total }}</td>
      </tr>
      <tr>
        <td></td>
        <td><strong>Delivery Charges</strong></td>
        <td>SR {{ $order->delivery_fees }}</td>
      </tr>
      <tr>
        <td></td>
        <td><strong>Grand Total</strong></td>
        <td>SR {{ $order->total }}</td>
      </tr>
    </tbody>
  </table>
<h4>Status:</h4>
<select onchange="menuStatus('{{ $order->id }}',this.value)" name="menuStatus" class="form-control">
<option value="open" {{ ($order->status == "open" ) ? 'selected="selected"' : ""}}>Open</option>
<option value="closed" {{ ($order->status == "closed") ? 'selected="selected"' : ""}} >Close</option>
<option value="cancel" {{ ($order->status == "cancel") ? 'selected="selected"' : ""}} >Cancel</option>
<option value="incomplete" {{ ($order->status == "incomplete") ? 'selected="selected"' : ""}} >Incomplete</option>
</select>
@endsection