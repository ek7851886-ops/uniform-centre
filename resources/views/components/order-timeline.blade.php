@php
  $steps = \App\Models\Order::statusSteps();
  $labels = \App\Models\Order::statusLabels();
  $currentIndex = $order->statusStepIndex();
@endphp
<div class="status-track">
  @foreach ($steps as $i => $step)
    <div class="status-step {{ $i <= $currentIndex ? 'done' : '' }}">
      <div class="status-dot">{{ $i < $currentIndex ? '✓' : $i + 1 }}</div>
      <div class="status-label">{{ $labels[$step] }}</div>
    </div>
  @endforeach
</div>
