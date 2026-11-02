
<td>
    @if($pertanyaan->status == 'draft')
        <span class="badge bg-secondary">Draft</span>

    @elseif($pertanyaan->status == 'pending')
        <span class="badge bg-warning text-dark">Pending</span>

    @elseif($pertanyaan->status == 'approved')
        <span class="badge bg-success">Approved</span>

    @elseif($pertanyaan->status == 'rejected')
        <span class="badge bg-danger">Rejected</span>

    @else
        <span class="badge bg-dark">
            {{ $pertanyaan->status }}
        </span>
    @endif
</td>
