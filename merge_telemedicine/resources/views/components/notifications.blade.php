<div class="dropdown">
    <button class="btn btn-link nav-link py-2 px-0 px-lg-2 dropdown-toggle d-flex align-items-center"
            id="bd-notifications"
            type="button"
            aria-expanded="false"
            data-bs-toggle="dropdown"
            data-bs-display="static">
        <i class="bi bi-bell"></i>
        @if(Auth::user()->unreadNotifications->count() > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ Auth::user()->unreadNotifications->count() }}
            </span>
        @endif
    </button>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="bd-notifications">
        @forelse(Auth::user()->notifications as $notification)
            <li>
                <a class="dropdown-item {{ $notification->read_at ? '' : 'bg-light' }}" href="#">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="mb-0">{{ $notification->message }}</p>
                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                        </div>
                        @if(!$notification->read_at)
                            <form action="{{ route('notifications.mark-as-read', $notification->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm text-primary">Tandai sudah dibaca</button>
                            </form>
                        @endif
                    </div>
                </a>
            </li>
        @empty
            <li><span class="dropdown-item">Tidak ada notifikasi</span></li>
        @endforelse
    </ul>
</div>