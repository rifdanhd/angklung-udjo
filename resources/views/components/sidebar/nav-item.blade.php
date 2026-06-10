@props(['route', 'active' => false, 'label', 'badge' => null, 'badgeColor' => 'bg-primary/10 text-primary'])

<a href="{{ $route }}"
   {{ $attributes->merge(['class' => 'flex items-center px-4 py-2.5 text-sm font-medium transition-all duration-200 rounded-lg group ' . ($active 
    ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400' 
    : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-200')]) }}>
    
    <div class="flex items-center flex-1">
        @if(isset($icon))
            <div class="mr-3 {{ $active ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 group-hover:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-400' }}">
                {{ $icon }}
            </div>
        @endif
        
        <span>{{ $label }}</span>
    </div>

    @if($badge)
        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold {{ $badgeColor }}">
            {{ $badge }}
        </span>
    @endif
</a>
