@foreach ($providerSubscriptions as $key => $providerSubscription)
    <tr>
        <td>{{ $key + 1 }}</td>
        <td>{{ $providerSubscription->provider->name }}</td>
        <td>{{ $providerSubscription->category->name }}</td>
        <td>{{ $providerSubscription->start_date }}
            <br>
            {{ $providerSubscription->start_date->diffForHumans() }}
        </td>
        <td>{{ $providerSubscription->end_date }}
            <br>
            {{ $providerSubscription->end_date->diffForHumans() }}
        </td>
        <td>{{ $providerSubscription->status }}</td>
        <td>
            {{ $providerSubscription->created_at->format('M d, Y') }}
            <br>
            {{ $providerSubscription->created_at->diffForHumans() }}
        </td>
        <td class="text-center">
            <a href="{{ route('admin.provider-subscriptions.show', $providerSubscription->uuid) }}" class="btn btn-outline-info btn-sm">
                <i class="fas fa-eye"></i>
            </a>
        </td>
    </tr>
@endforeach
