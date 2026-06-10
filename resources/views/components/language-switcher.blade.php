<div class="relative inline-block" x-data="{ open: false }">
    <button @click="open = !open" 
            class="flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/20 transition-all">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
        </svg>
        <span class="font-medium">{{ strtoupper(app()->getLocale()) }}</span>
        <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>
    
    <div x-show="open" 
         @click.away="open = false"
         x-transition
         class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-2xl overflow-hidden z-50">
        
        <a href="{{ route('language.switch', 'id') }}" 
           class="flex items-center gap-3 px-4 py-3 hover:bg-amber-50 transition-colors {{ app()->getLocale() === 'id' ? 'bg-amber-100 text-amber-800' : 'text-gray-700' }}">
            <span class="text-2xl">🇮🇩</span>
            <div>
                <div class="font-semibold">Bahasa Indonesia</div>
                <div class="text-xs text-gray-500">Indonesian</div>
            </div>
            @if(app()->getLocale() === 'id')
                <svg class="w-5 h-5 ml-auto text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
            @endif
        </a>
        
        <a href="{{ route('language.switch', 'en') }}" 
           class="flex items-center gap-3 px-4 py-3 hover:bg-amber-50 transition-colors {{ app()->getLocale() === 'en' ? 'bg-amber-100 text-amber-800' : 'text-gray-700' }}">
            <span class="text-2xl">🇬🇧</span>
            <div>
                <div class="font-semibold">English</div>
                <div class="text-xs text-gray-500">English</div>
            </div>
            @if(app()->getLocale() === 'en')
                <svg class="w-5 h-5 ml-auto text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
            @endif
        </a>
    </div>
</div>