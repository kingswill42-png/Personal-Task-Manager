<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUEST LOG // SYSTEM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #050505; 
            color: #e4e4e7;
        }
        .font-mono { font-family: 'JetBrains Mono', monospace; }

        .monarch-box {
            background-color: #09090b;
            border: 1px solid #1f1f22;
        }
        .monarch-card {
            background-color: #09090b;
            border: 1px solid #1f1f22;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .monarch-card:hover {
            border-color: #7c3aed;
            background-color: #0c0a10;
            box-shadow: 0 0 15px rgba(124, 58, 237, 0.15);
        }
        .monarch-input {
            background-color: #000000;
            border: 1px solid #1f1f22;
            color: #ffffff;
            transition: all 0.2s ease;
        }
        .monarch-input:focus {
            border-color: #9333ea;
            box-shadow: 0 0 10px rgba(147, 51, 234, 0.2);
            outline: none;
        }
        .btn-arise {
            background-color: transparent;
            color: #a855f7;
            border: 1px solid #a855f7;
            font-weight: 700;
            transition: all 0.2s ease;
        }
        .btn-arise:hover {
            background-color: #a855f7;
            color: #000000;
            box-shadow: 0 0 15px rgba(168, 85, 247, 0.4);
        }
        ::-webkit-calendar-picker-indicator {
            filter: invert(1);
            cursor: pointer;
            opacity: 0.5;
        }
        ::-webkit-calendar-picker-indicator:hover {
            opacity: 1;
        }
    </style>
</head>
<body class="min-h-screen p-6 md:p-12 selection:bg-purple-600 selection:text-white">

    <div class="max-w-5xl mx-auto">
        
        <!-- Header -->
        <header class="mb-12 border-b border-zinc-800 pb-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <div class="flex items-center space-x-3 mb-2">
                    <span class="px-2 py-0.5 bg-purple-900/30 border border-purple-500/50 text-purple-400 text-[10px] font-mono font-bold uppercase tracking-widest">SYSTEM</span>
                    <span class="text-xs font-mono text-zinc-500">// PLAYER LOG</span>
                </div>
                <h1 class="text-3xl font-extrabold tracking-tight text-white font-mono uppercase drop-shadow-[0_0_10px_rgba(147,51,234,0.3)]">Daily Quests</h1>
            </div>

            <!-- Stats Bar -->
            <div class="flex items-center space-x-2 font-mono text-xs">
                <div class="monarch-box px-4 py-2.5 rounded-none flex items-center space-x-3 border-l-2 border-l-purple-600">
                    <span class="text-zinc-500 uppercase">Total</span>
                    <span class="text-white font-bold">{{ $tasks->count() }}</span>
                </div>
                <div class="monarch-box px-4 py-2.5 rounded-none flex items-center space-x-3">
                    <span class="text-zinc-500 uppercase">Cleared</span>
                    <span class="text-purple-400 font-bold">{{ $tasks->where('status', 'Completed')->count() }}</span>
                </div>
                <div class="monarch-box px-4 py-2.5 rounded-none flex items-center space-x-3">
                    <span class="text-zinc-500 uppercase">Active</span>
                    <span class="text-white font-bold">{{ $tasks->where('status', 'Pending')->count() }}</span>
                </div>
            </div>
        </header>

        <!-- Flash Alert -->
        @if(session('success'))
            <div class="mb-8 p-4 bg-[#0a0a0c] border border-purple-600 text-xs font-mono text-purple-100 flex items-center justify-between shadow-[0_0_10px_rgba(147,51,234,0.2)]">
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-bolt text-purple-500"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-zinc-500 hover:text-white transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        <!-- Quick Entry Section -->
        <section class="monarch-box p-6 md:p-8 mb-12">
            <div class="flex items-center justify-between mb-6 pb-3 border-b border-zinc-800">
                <span class="text-xs font-mono uppercase tracking-widest text-purple-400">
                    [+] Issue New Directive
                </span>
            </div>

            <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-mono uppercase text-zinc-500 mb-1">Quest Title</label>
                        <input type="text" name="task_name" required class="w-full p-3.5 monarch-input text-sm" placeholder="Enter objective...">
                    </div>
                    <div>
                        <label class="block text-[10px] font-mono uppercase text-zinc-500 mb-1">Time Limit (Date)</label>
                        <input type="date" name="due_date" class="w-full p-3.5 monarch-input text-sm text-zinc-300">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-mono uppercase text-zinc-500 mb-1">System Notes / Penalties</label>
                    <textarea name="description" rows="2" class="w-full p-3.5 monarch-input text-sm resize-none" placeholder="Add specific requirements..."></textarea>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="btn-arise px-6 py-3 text-xs font-mono uppercase tracking-wider">
                        Arise (Add Task)
                    </button>
                </div>
            </form>
        </section>

        <!-- Task Listing -->
        <section>
            <div class="flex items-center justify-between mb-4 font-mono text-xs text-zinc-500 uppercase tracking-widest">
                <span>// Active Log</span>
                <span class="text-purple-500/50">{{ $tasks->count() }} Entities Found</span>
            </div>

            <div class="space-y-2">
                @forelse($tasks as $task)
                    <div class="monarch-card p-5 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        
                        <div class="space-y-1.5 flex-1 pr-4">
                            <div class="flex items-center space-x-3">
                                @if($task->status === 'Completed')
                                    <span class="px-2 py-0.5 bg-zinc-900 text-zinc-500 font-mono text-[10px] uppercase tracking-wider border border-zinc-800">
                                        CLEARED
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 bg-purple-900/20 text-purple-400 border border-purple-500/50 font-mono text-[10px] font-bold uppercase tracking-wider shadow-[0_0_8px_rgba(147,51,234,0.2)]">
                                        ACTIVE
                                    </span>
                                @endif

                                <h3 class="text-sm font-medium tracking-tight {{ $task->status === 'Completed' ? 'line-through text-zinc-600' : 'text-white drop-shadow-md' }}">
                                    {{ $task->task_name }}
                                </h3>
                            </div>

                            @if($task->description)
                                <p class="text-xs text-zinc-500 font-light leading-relaxed pl-1">
                                    {{ $task->description }}
                                </p>
                            @endif
                        </div>

                        <!-- Date & Options -->
                        <div class="flex items-center justify-between md:justify-end space-x-6 border-t md:border-t-0 border-zinc-800 pt-3 md:pt-0 font-mono">
                            
                            <span class="text-xs {{ $task->status === 'Completed' ? 'text-zinc-600' : 'text-purple-400/70' }} tracking-tight">
                                {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y.m.d') : 'NO LIMIT' }}
                            </span>

                            <div class="flex items-center space-x-1">
                                <form action="{{ route('tasks.toggleStatus', $task) }}" method="POST" 
                                      onsubmit="{{ $task->status === 'Pending' ? 'triggerShadowConfetti(event, this)' : '' }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-9 h-9 border border-zinc-800 hover:border-purple-500 text-zinc-500 hover:text-purple-400 flex items-center justify-center transition-all hover:shadow-[0_0_10px_rgba(147,51,234,0.3)]" title="Toggle Status">
                                        <i class="fa-solid fa-check text-xs"></i>
                                    </button>
                                </form>

                                <a href="{{ route('tasks.edit', $task) }}" class="w-9 h-9 border border-zinc-800 hover:border-zinc-400 text-zinc-500 hover:text-white flex items-center justify-center transition-colors" title="Edit">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </a>

                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Extract this shadow? (Delete)');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-9 h-9 border border-zinc-800 hover:border-red-600 hover:bg-red-950/30 text-zinc-500 hover:text-red-500 flex items-center justify-center transition-all" title="Delete">
                                        <i class="fa-solid fa-skull text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="text-center py-16 monarch-box">
                        <p class="text-xs font-mono text-zinc-600 uppercase tracking-widest">// NO QUESTS ISSUED BY THE SYSTEM</p>
                    </div>
                @endforelse
            </div>
        </section>

    </div>

    <script>
        function triggerShadowConfetti(e, form) {
            e.preventDefault(); 
            confetti({
                particleCount: 60,
                spread: 70,
                origin: { y: 0.6 },
                colors: ['#9333ea', '#a855f7', '#d8b4fe', '#000000', '#18181b'],
                disableForReducedMotion: true,
                zIndex: 100
            });
            setTimeout(() => { form.submit(); }, 400); 
        }
    </script>
</body>
</html>