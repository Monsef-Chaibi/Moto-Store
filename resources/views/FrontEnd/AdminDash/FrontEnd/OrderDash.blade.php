<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Dashboard - Analytics | Sneat - Bootstrap 5 HTML Admin Template - Pro</title>

    <meta name="description" content="" />

    @include('FrontEnd.AdminDash.FrontEnd.Include.HeadLink')

  </head>

  <body>

    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">

        <!-- Menu -->
            @include('FrontEnd.AdminDash.FrontEnd.Include.SideBar')
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">

          <!-- Navbar -->
            @include('FrontEnd.AdminDash.FrontEnd.Include.NavBar')
          <!-- / Navbar -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Order </h4>
              <!-- Basic Bootstrap Table -->
              <div class="card">
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Order</th>
                        <th>Date</th>
                        <th>Price</th>
                        <th>Items</th>
                        <th>User</th>
                        <th>Status
                            <span class="text-[10px]">
                                (Click To Change)
                            </span>
                        </th>
                      </tr>
                    </thead>
                    <tbody>

                        @foreach($orders as $order)
                            <tr>
                                <td class="text-blue-600">#{{ $order->id }}</td>
                                <td>{{ $order->created_at->format('d-m-Y H:i:s') }}</td>
                                <td>{{ $order->total_price }} MAD</td>
                                <td>
                                    <ul>
                                        @foreach($order->orderItems as $item)
                                            <li>{{ $item->product->name }} ({{ $item->quantity }})</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>{{ $order->user->name }}</td>
                                <td>
                                    @if($order->status == 'pending')
                                        <form action="{{ route('order.confirm', $order) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="badge bg-warning">
                                                {{ $order->status }}
                                            </button>
                                        </form>
                                    @elseif($order->status == 'confirmed')
                                        <span class="badge bg-success">{{$order->status}}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
              <!--/ Basic Bootstrap Table -->
        </div>



        @include('FrontEnd.AdminDash.FrontEnd.Include.Script')


  </body>
</html>
