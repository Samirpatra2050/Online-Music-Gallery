@extends('layouts.app')

@section('content')

<!-- Bottom Music Player -->
<div id="player-bar" class="player-bar">
    <img id="player-cover" src="" alt="cover"> 
    <div class="player-info">
        <h6 id="player-title">Title</h6>
        <p id="player-artist">Artist</p>
    </div>
    <button id="player-play">▶</button>
    <input type="range" id="player-progress" value="0" min="0" max="100">
    <span id="player-time">0:00</span>
    <button id="player-cancel" style="background: transparent; border: none; color: #fff; font-size: 18px; cursor: pointer; margin-left: 10px;">✖</button>
</div>

<div class="container">
    <h2 class="mb-4">Welcome, {{ Auth::user()->name }} 🎶</h2>

    @foreach($musicByGenre as $genre => $tracks)
        <h3 class="mt-5 mb-3 text-primary">{{ $genre ?? 'Other' }}</h3>
        <div class="row">
            @foreach($tracks as $track)
                <div class="col-md-3 mb-4">
                    <div class="card h-80 shadow-md text-center">
                        <!-- Cover image -->
                        <img src="{{ $track->coverUrl }}" 
                             class="music-cover play-cover" 
                             alt="{{ $track->title }}"
                             data-file="{{ $track->musicUrl }}"
                             data-title="{{ $track->title }}"
                             data-artist="{{ $track->artist }}"
                             data-cover="{{ $track->coverUrl }}"
                             data-id="{{ $track->id }}">

                        <div class="card-body">
                            <h5 class="card-title">{{ $track->title }}</h5>
                            <p class="card-text text-muted" style="position:relative; display:inline-block;">
                                {{ $track->artist }}
                                <span class="play-count-badge" data-id="{{ $track->id }}">
                                    {{ $track->play_count }}
                                </span>
                            </p>
                    
                            <div class="music-buttons">
                                <button class="music-btn play-btn"
                                    data-file="{{ $track->musicUrl }}"
                                    data-title="{{ $track->title }}"
                                    data-artist="{{ $track->artist }}"
                                    data-cover="{{ $track->coverUrl }}"
                                    data-id="{{ $track->id }}">
                                    ▶ Play
                                </button>

                                <button class="music-btn favorite-btn"
                                    data-id="{{ $track->id }}">
                                    💖 Favorite
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>

</div>
@endsection

<style>
/* Floating Bottom Player */
.music-cover {
    width: 100%;
    height: 200px;                /* keep full original ratio */
    border-radius: 12px;
    display: block;
}
.music-cover:hover {
    transform: scale(1.05);      
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
}


.player-bar {
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    width: 90%;
    max-width: 700px;
    
    background: rgba(24, 24, 24, 0.6); /* semi-transparent background */
    backdrop-filter: blur(12px) saturate(150%); /* frosted glass effect */
    -webkit-backdrop-filter: blur(12px) saturate(150%); /* Safari support */
    
    color: #fff;
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 18px;
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, 0.15); /* subtle border */
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
    z-index: 1000;
    display: none;
    transition: all 0.3s ease-in-out;
}

.player-bar img {
    width: 55px;
    height: 55px;
    border-radius: 12px;
    object-fit: cover;
    flex-shrink: 0;
}
.player-info {
    flex: 1;
    min-width: 0;
}
.player-info h6 {
    margin: 0;
    font-size: 15px;
    font-weight: 600;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.player-info p {
    margin: 0;
    font-size: 13px;
    color: #bbb;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
#player-play {
    background: #1db954;
    border: none;
    color: #fff;
    border-radius: 50%;
    padding: 10px 14px;
    font-size: 18px;
    cursor: pointer;
}
#player-progress {
    flex: 1;
    height: 4px;
    border-radius: 3px;
    background: #444;
    appearance: none;
}
#player-progress::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #1db954;
    cursor: pointer;
}
#player-time {
    font-size: 12px;
    color: #aaa;
    min-width: 40px;
    text-align: right;
}

.play-count-badge {
    display: inline-block;
    background-color: #28a745;
    color: #fff;
    font-weight: bold;
    font-size: 12px;
    width: 30px;
    height:30px;
    padding: 4px 8px;
    border-radius: 10px 5px;
    position: absolute;
    top: -5px;
    right: -80px;
    cursor: pointer;
    transition: transform 0.2s;
}

.play-count-badge:hover {
    transform: scale(1.2);
}

.play-btn, .favorite-btn {
    font-weight: bold;
    transition: transform 0.2s, background-color 0.2s;
    cursor: pointer;
    border-radius: 50px;
}

.music-btn {
    width: 48%;
    padding: 8px 0;
    border-radius: 20px;
    font-weight: bold;
    border: none;
    cursor: pointer;
    transition: transform 0.2s, background-color 0.2s;
    text-align: center;
}

.play-btn {
    background-color: #4caf50;
    color: #fff;
}

.favorite-btn {
    background-color: #f28b82;
    color: #fff;
}

.music-btn:hover {
    opacity: 0.9;
}

.music-btn:active {
    transform: scale(0.95);

}
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let currentAudio = null;
    const playerBar = document.getElementById("player-bar");
    const playerCover = document.getElementById("player-cover");
    const playerTitle = document.getElementById("player-title");
    const playerArtist = document.getElementById("player-artist");
    const playerPlay = document.getElementById("player-play");
    const playerProgress = document.getElementById("player-progress");
    const playerTime = document.getElementById("player-time");
    const playerCancel = document.getElementById("player-cancel");
    let isPlaying = false;

    function playTrack(file, title, artist, cover, musicId) {
        if (currentAudio) currentAudio.pause();
        currentAudio = new Audio(file);
        playerCover.src = cover;
        playerTitle.textContent = title;
        playerArtist.textContent = artist;
        playerBar.style.display = "flex";
        playerPlay.textContent = "⏸";
        isPlaying = true;
        currentAudio.play();

        // Increment play count via AJAX
        if (musicId) {
            fetch(`/music/${musicId}/play`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
            }).then(response => response.json())
              .then(data => {
                  console.log('Play count updated:', data.play_count);

                  // Update play count badge
                  let badge = document.querySelector(`.play-count-badge[data-id='${musicId}']`);
                  if (badge) {
                      badge.textContent = data.play_count;
                  }
              })
              .catch(err => console.error(err));
        }

        currentAudio.addEventListener("timeupdate", () => {
            if (!currentAudio.duration) return;
            let percent = (currentAudio.currentTime / currentAudio.duration) * 100;
            playerProgress.value = percent;
            let minutes = Math.floor(currentAudio.currentTime / 60);
            let seconds = Math.floor(currentAudio.currentTime % 60);
            playerTime.textContent = `${minutes}:${seconds < 10 ? "0"+seconds : seconds}`;
        });

        currentAudio.addEventListener("ended", () => {
            playerPlay.textContent = "▶";
            isPlaying = false;
            playerProgress.value = 0;
            playerTime.textContent = "0:00";
        });
    }

    document.querySelectorAll(".play-btn, .play-cover").forEach(el => {
        el.addEventListener("click", function () {
            playTrack(
                this.dataset.file,
                this.dataset.title,
                this.dataset.artist,
                this.dataset.cover,
                this.dataset.id
            );
        });
    });

    playerPlay.addEventListener("click", () => {
        if (!currentAudio) return;
        if (isPlaying) {
            currentAudio.pause();
            playerPlay.textContent = "▶";
        } else {
            currentAudio.play();
            playerPlay.textContent = "⏸";
        }
        isPlaying = !isPlaying;
    });

    playerCancel.addEventListener("click", () => {
        if (currentAudio) currentAudio.pause();
        currentAudio = null;
        playerBar.style.display = "none";
        playerProgress.value = 0;
        playerTime.textContent = "0:00";
    });

    playerProgress.addEventListener("input", () => {
        if (currentAudio && currentAudio.duration) {
            currentAudio.currentTime = (playerProgress.value / 100) * currentAudio.duration;
        }
    });
});
</script>
