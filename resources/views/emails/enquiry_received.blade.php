<p>A new enquiry has been submitted.</p>

<ul>
    <li><strong>Name:</strong> {{ $enquiry->name }}</li>
    <li><strong>Email:</strong> {{ $enquiry->email }}</li>
    <li><strong>Phone:</strong> {{ $enquiry->phone }}</li>
    <li><strong>Service:</strong> {{ $enquiry->service }}</li>
</ul>

<p><strong>Message:</strong></p>
<p>{!! nl2br(e($enquiry->message)) !!}</p>
