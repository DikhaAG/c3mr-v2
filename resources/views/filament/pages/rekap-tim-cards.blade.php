<div class="grid grid-cols-1 gap-4">
    @foreach ($tims as $tim)
        <x-filament::card>
            <h2 class="font-bold text-lg mb-2">
                {{ $tim['nama'] }}
            </h2>

            <div class="space-y-1 text-sm">
                @foreach ($tim['items'] as $ket => $jumlah)
                    <div class="flex justify-between">
                        <span>{{ $ket }}</span>
                        <span class="font-medium">{{ $jumlah }}</span>
                    </div>
                @endforeach
            </div>

            <div class="border-t mt-3 pt-2 flex justify-between font-bold">
                <span>Total</span>
                <span>{{ $tim['total'] }}</span>
            </div>
        </x-filament::card>
    @endforeach
</div>
