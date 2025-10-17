@extends('admin.maindesign')

@section('orders')

<div class="container-fluid">
    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Orders</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Orders Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Orders</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Payment Method</th>
                            <th>Payment Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>
                                    <strong>{{ $order->user->name ?? 'N/A' }}</strong><br>
                                    <small class="text-muted">{{ $order->user->email ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    <strong>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</strong><br>
                                    <small class="text-muted">{{ $order->orderItems->count() }} items</small>
                                </td>
                                <td>
                                    @if($order->payment_method == 'transfer_bank')
                                        <span class="badge badge-info">Transfer Bank</span>
                                    @elseif($order->payment_method == 'qris')
                                        <span class="badge badge-primary">QRIS</span>
                                    @elseif($order->payment_method == 'cod')
                                        <span class="badge badge-warning">COD</span>
                                    @else
                                        <span class="badge badge-secondary">{{ $order->payment_method }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($order->payment_status == 'success')
                                        <span class="badge badge-success">Success</span>
                                    @elseif($order->payment_status == 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @else
                                        <span class="badge badge-danger">Failed</span>
                                    @endif
                                </td>
                                <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.detail', $order) }}" 
                                       class="btn btn-sm btn-primary">
                                        <i class="fa fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada order</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>

@endsection