<div>
    @foreach($logs as $log)
        <div>
            [{{ $log->created_at->format('H:m:s | m-d-Y') }}] {{ $log->log }}
        </div>
    @endforeach
</div>
