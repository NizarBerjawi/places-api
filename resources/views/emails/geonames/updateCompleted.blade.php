@component('mail::message')

Places API database was successfully updated with new Geonames data.

Summary:
@component('mail::table')
|                |                               |
| -------------- |:-----------------------------:|
| Batch ID       | {{ $batch->id }}              |
| Batch Name     | {{ $batch->name }}            |
| Processed Jobs | {{ $batch->processedJobs() }} |
| Pending Jobs   | {{ $batch->pendingJobs }}     |
| Failed Jobs    | {{ $batch->failedJobs }}      |
| Total Jobs     | {{ $batch->totalJobs }}       |
| Created At     | {{ $batch->createdAt }}       |
@endcomponent

Thanks,<br>
The {{ config('app.name') }} Team
@endcomponent
