<div x-data="chatbotWidget()" class="fixed bottom-6 right-6 z-[9999]">
    <!-- Chat Button -->
    <button @click="isOpen = !isOpen"
        class="w-16 h-16 bg-brand-orange rounded-full shadow-2xl hover:bg-orange-600 transition-all duration-300 flex items-center justify-center text-white text-2xl ring-4 ring-orange-200/50 relative z-[9999]"
        x-data="{ hovered: false }" @mouseenter="hovered = true" @mouseleave="hovered = false"
        :style="hovered ? 'transform: scale(1.1)' : ''">
        <i class="ph transition-transform duration-300" :class="isOpen ? 'ph-x rotate-90' : 'ph-chat-circle-dots'"></i>
    </button>

    <!-- Chat Window -->
    <div x-show="isOpen" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90 translate-y-5"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-90 translate-y-5"
        class="absolute bottom-20 right-0 w-96 h-[600px] bg-white rounded-2xl shadow-2xl border border-gray-200 flex flex-col overflow-hidden z-[9999]"
        style="display: none;">
        <!-- Header -->
        <div class="bg-gradient-to-r from-brand-orange to-orange-600 text-white p-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center backdrop-blur"
                    x-data="{ rotating: false }" x-init="setInterval(() => { rotating = !rotating }, 2000)"
                    :class="rotating ? 'rotate-12' : '-rotate-12'" style="transition: transform 0.3s;">
                    <i class="ph ph-robot text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold">Rumba Athaya</h3>
                    <p class="text-xs text-amber-100">Chatbot Assistant</p>
                </div>
            </div>
            <button @click="isOpen = false" class="text-white hover:text-amber-100 transition"
                x-data="{ hovered: false }" @mouseenter="hovered = true" @mouseleave="hovered = false"
                :style="hovered ? 'transform: scale(1.1) rotate(90deg)' : ''">
                <i class="ph ph-x text-xl"></i>
            </button>
        </div>

        <!-- Messages Container -->
        <div class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50" x-ref="messagesContainer"
            x-effect="$nextTick(() => { $refs.messagesContainer.scrollTop = $refs.messagesContainer.scrollHeight })">
            <template x-for="(message, index) in messages" :key="message.id">
                <div class="flex items-start gap-3" :class="message.isUser ? 'flex-row-reverse' : ''"
                    x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, index * 100)" x-show="loaded"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0"
                        :class="message.isUser ? 'bg-brand-orange' : 'bg-orange-100'">
                        <i class="ph" :class="message.isUser ? 'ph-user text-white' : 'ph-robot text-brand-orange'"></i>
                    </div>
                    <div class="flex-1" :class="message.isUser ? 'flex justify-end' : ''">
                        <div class="rounded-2xl p-4 shadow-sm max-w-[80%]"
                            :class="message.isUser ? 'bg-brand-orange text-white rounded-tr-sm' : 'bg-white text-gray-700 rounded-tl-sm'">
                            <p class="text-sm whitespace-pre-wrap" x-text="message.text"></p>
                            <template x-if="!message.isUser && !message.text.includes('WhatsApp')">
                                <a href="https://wa.me/6282313509532?text=Halo,%20saya%20ingin%20bertanya%20tentang%20Rumba%20Athaya"
                                    target="_blank" rel="noopener noreferrer"
                                    class="mt-3 inline-flex items-center gap-2 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition text-sm">
                                    <i class="ph ph-whatsapp-logo"></i>
                                    Chat via WhatsApp
                                </a>
                            </template>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Typing Indicator -->
            <div x-show="isTyping" class="flex items-start gap-3" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="ph ph-robot text-brand-orange"></i>
                </div>
                <div class="flex-1">
                    <div class="bg-white rounded-2xl rounded-tl-sm p-4 shadow-sm">
                        <div class="flex gap-1">
                            <template x-for="i in 3" :key="i">
                                <div class="w-2 h-2 bg-gray-400 rounded-full" x-data="{ bouncing: false }"
                                    x-init="setInterval(() => { bouncing = !bouncing }, 600)"
                                    :style="bouncing ? 'transform: translateY(-8px)' : ''"
                                    style="transition: transform 0.6s; animation-delay: calc(var(--i) * 0.2s);"></div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="p-4 border-t border-gray-200 bg-white">
            <div class="flex gap-2">
                <input type="text" x-model="input"
                    @keypress.enter="if(!isTyping && input.trim()) { sendMessage(input); }"
                    placeholder="Tanya sesuatu..."
                    class="flex-1 px-4 py-2 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent transition-all"
                    :disabled="isTyping">
                <button @click="if(!isTyping && input.trim()) { sendMessage(input); }"
                    :disabled="!input.trim() || isTyping"
                    class="w-10 h-10 bg-brand-orange text-white rounded-xl hover:bg-orange-600 transition flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed"
                    x-data="{ hovered: false }" @mouseenter="hovered = true" @mouseleave="hovered = false"
                    :style="hovered && !isTyping ? 'transform: scale(1.05)' : ''">
                    <i class="ph ph-paper-plane-tilt"></i>
                </button>
            </div>
            <!-- Quick Actions -->
            <div class="mt-2 flex flex-wrap gap-2">
                @php
                    $quickQuestions = [
                        ['query' => 'cara daftar', 'label' => 'Cara Daftar'],
                        ['query' => 'biaya bimbel', 'label' => 'Biaya'],
                        ['query' => 'program tersedia', 'label' => 'Program'],
                        ['query' => 'konsultasi gratis', 'label' => 'Konsultasi'],
                    ];
                @endphp
                @foreach($quickQuestions as $index => $q)
                    <button @click="sendMessage('{{ $q['query'] }}')" :disabled="isTyping"
                        class="text-xs px-3 py-1.5 bg-gray-100 hover:bg-brand-orange hover:text-white rounded-full transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                        x-data="{ hovered: false }" @mouseenter="hovered = true" @mouseleave="hovered = false"
                        :style="hovered && !isTyping ? 'transform: scale(1.05)' : ''">
                        {{ $q['label'] }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    function chatbotWidget() {
        return {
            isOpen: false,
            messages: [
                {
                    id: '1',
                    text: '👋 Halo! Saya adalah asisten Rumba Athaya. Saya siap membantu menjawab pertanyaan Anda tentang program, pendaftaran, atau informasi lainnya.',
                    isUser: false,
                    timestamp: new Date()
                }
            ],
            input: '',
            isTyping: false,
            sendMessage(query) {
                if (!query.trim() || this.isTyping) return;

                // Add user message
                this.messages.push({
                    id: Date.now().toString(),
                    text: query,
                    isUser: true,
                    timestamp: new Date()
                });

                const userQuery = query;
                this.input = '';
                this.isTyping = true;

                // Call chatbot API
                fetch('/api/chatbot/query', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ query: userQuery })
                })
                    .then(response => response.json())
                    .then(data => {
                        this.isTyping = false;

                        if (data.success && data.results && data.results.length > 0) {
                            // Show first result
                            this.messages.push({
                                id: Date.now().toString(),
                                text: data.results[0].answer || data.results[0].formatted,
                                isUser: false,
                                timestamp: new Date()
                            });

                            // If multiple results, show options
                            if (data.results.length > 1) {
                                setTimeout(() => {
                                    this.messages.push({
                                        id: Date.now().toString(),
                                        text: `Saya menemukan ${data.results.length} jawaban terkait. Apakah ada yang ingin Anda tanyakan lebih lanjut?`,
                                        isUser: false,
                                        timestamp: new Date()
                                    });
                                }, 500);
                            }
                        } else {
                            // No answer found, suggest WhatsApp
                            this.messages.push({
                                id: Date.now().toString(),
                                text: 'Maaf, saya tidak menemukan jawaban untuk pertanyaan Anda. Silakan hubungi kami langsung via WhatsApp untuk informasi lebih lanjut.',
                                isUser: false,
                                timestamp: new Date()
                            });
                        }
                    })
                    .catch(error => {
                        this.isTyping = false;
                        this.messages.push({
                            id: Date.now().toString(),
                            text: 'Maaf, terjadi kesalahan. Silakan coba lagi atau hubungi kami via WhatsApp.',
                            isUser: false,
                            timestamp: new Date()
                        });
                    });
            }
        };
    }
</script>