@extends('adminpanel.cirrb')

@section('page-title')
	Orders
@endsection

@section('content')
	
	<div class="clearfix"></div>
  <div class="table-box">
    <table class="table table-bordered">
    <thead>
      <tr>
      	<th>#ID</th>
        <th>Customer Name</th>
        <th>Email</th>
        <th>Phone</th>
      	<th>Total</th>
      </tr>
    </thead>
    <tbody>
      @foreach( $orders as $order )

        <tr onclick="redirectMeOrder('{{$order->id}}')">
          <td>#{{ $order->id }}</td>
          <td>{{ $order->user->name}}</td>
          <td>{{ $order->user->email }}</td>
          <td>{{ $order->user->phone }}</td>
          <td>SR {{ $order->total }}</td
        </tr>

      @endforeach

    </tbody>
  </table>
{{ $orders->links() }}
@endsection