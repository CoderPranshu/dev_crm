@extends('index')

@push('css')

<style>
    .chat-header{

background:#fff;

padding:20px;

border-radius:15px 15px 0 0;

border-bottom:1px solid #eee;

}

.chat-body{

height:600px;

overflow-y:auto;

background:#f8fafc;

padding:25px;

}

.message{

display:flex;

margin-bottom:18px;

}

.me{

justify-content:flex-end;

}

.other{

justify-content:flex-start;

}

.bubble{

max-width:70%;

padding:14px 18px;

border-radius:18px;

box-shadow:0 5px 20px rgba(0,0,0,.05);

}

.bubble-me{

background: #7ed6c4d9;

color:#fff;

}

.bubble-other{

background:#fff;

}

.chat-footer{

display:flex;

gap:10px;

padding:18px;

background:#fff;

border-top:1px solid #eee;

}

.chat-file{

display:block;

text-decoration:none;

margin-top:6px;

font-size:13px;

}

.bubble-me small{

color:#dbeafe;

}

.bubble-other small{

color:#999;

}

.chat-image{
    width:220px;
    border-radius:12px;
    cursor:pointer;
    transition:.3s;
}

.chat-image:hover{
    transform:scale(1.03);
}

.file-box{

display:flex;

align-items:center;

gap:10px;

padding:10px 15px;

border-radius:10px;

background:#f5f7fb;

margin-top:8px;

text-decoration:none;

}

.chat-video{

width:260px;

border-radius:12px;

}


</style>

@endpush

@section('content')

<div class="container-fluid py-4">

    <div class="row justify-content-center">

        <div class="col-xl-12">

            <!-- Header -->

            <div class="chat-header">

                <div>

                    <h4>{{ $project->project_name }}</h4>

                    <small>
                        Lead Developer ↔ Customer Chat
                    </small>

                </div>

            </div>

            <!-- Messages -->

            <div class="chat-body" id="chatBody">

                @foreach($messages as $message)

                    @if($message->sender_id == auth()->id())

                        <!-- My Message -->

                        <div class="message me">

                            <div class="bubble bubble-me">

                                @if($message->message)

                                    <p>{{ $message->message }}</p>

                                @endif

                                @if($message->files->count())

                                    <div class="mt-2">

                                        <!-- @foreach($message->files as $file)

                                            <a
                                                href="{{ asset($file->file_path) }}"
                                                target="_blank"
                                                class="chat-file"
                                            >
                                                📎 {{ $file->original_name }}
                                            </a>

                                        @endforeach -->

                                        @foreach($message->files as $file)

                                            @if(Str::startsWith($file->mime_type,'image/'))

                                                <a href="{{ asset($file->file_path) }}" target="_blank">

                                                    <img
                                                        src="{{ asset($file->file_path) }}"
                                                        class="chat-image"
                                                    >

                                                </a>

                                            @endif

                                            @if(Str::startsWith($file->mime_type,'video/'))

                                                <video
                                                controls
                                                class="chat-video">

                                                <source
                                                src="{{ asset($file->file_path) }}">

                                                </video>

                                            @endif

                                            @if(Str::startsWith($file->mime_type,'audio/'))

                                                <audio controls>

                                                <source
                                                src="{{ asset($file->file_path) }}">

                                                </audio>

                                            @endif

                                            @if(Str::contains($file->mime_type,'pdf'))

                                                <a
                                                href="{{ asset($file->file_path) }}"
                                                target="_blank"
                                                class="btn btn-sm btn-danger">

                                                <i class="bi bi-file-earmark-pdf"></i>

                                                View PDF

                                                </a>

                                            @endif


                                            @php

                                            $icon="bi bi-file-earmark";

                                            if(Str::contains($file->mime_type,'pdf'))
                                            {
                                                $icon="bi bi-file-earmark-pdf text-danger";
                                            }
                                            elseif(Str::contains($file->mime_type,'word'))
                                            {
                                                $icon="bi bi-file-earmark-word text-primary";
                                            }
                                            elseif(Str::contains($file->mime_type,'zip'))
                                            {
                                                $icon="bi bi-file-earmark-zip text-warning";
                                            }
                                            elseif(Str::contains($file->mime_type,'excel'))
                                            {
                                                $icon="bi bi-file-earmark-excel text-success";
                                            }

                                            @endphp

                                            <a
                                            href="{{ asset($file->file_path) }}"
                                            target="_blank"
                                            class="file-box">

                                            <i class="{{ $icon }}"></i>

                                            {{ $file->original_name }}

                                            </a>


                                        @endforeach

                                    </div>

                                @endif

                                <small>

                                    {{ $message->created_at->format('d M Y h:i A') }}

                                </small>

                            </div>

                        </div>

                    @else

                        <!-- Other Message -->

                        <div class="message other">

                            <div class="bubble bubble-other">

                                <strong>

                                    {{ $message->sender->name }}

                                </strong>

                                @if($message->message)

                                    <p>{{ $message->message }}</p>

                                @endif

                                @if($message->files->count())

                                    <div class="mt-2">

                                        @foreach($message->files as $file)

                                            <a
                                                href="{{ asset($file->file_path) }}"
                                                target="_blank"
                                                class="chat-file"
                                            >
                                                📎 {{ $file->original_name }}
                                            </a>

                                        @endforeach

                                    </div>

                                @endif

                                <small>

                                    {{ $message->created_at->format('d M Y h:i A') }}

                                </small>

                            </div>

                        </div>

                    @endif

                @endforeach

            </div>

            <!-- Send Message -->

            <form
                action="{{ route('admin.projects.chat.store',$project->id) }}"
                method="POST"
                enctype="multipart/form-data"
                class="chat-footer"
            >

                @csrf

                <input
                    type="text"
                    name="message"
                    class="form-control"
                    placeholder="Type your message..."
                >

                <div id="dropZone">

                    Drop Files Here

                </div>


                <input
                    type="file"
                    name="files[]"
                    multiple
                    class="form-control"
                    id="fileInput"
                    hidden

                >

                <button class="btn btn-primary">
                    Send
                </button>
                
            </form>

        </div>

    </div>

</div>

@endsection

@push('js')

<script>

    let chat=document.getElementById('chatBody');

    chat.scrollTop=chat.scrollHeight;

    const zone=document.getElementById('dropZone');

        zone.onclick=()=>fileInput.click();

        zone.ondragover=e=>{

        e.preventDefault();

        }

        zone.ondrop=e=>{

        e.preventDefault();

        fileInput.files=e.dataTransfer.files;

    }

    const body=document.querySelector(".chat-body");

    body.scrollTop=body.scrollHeight;

    const input=document.querySelector("[name=message]");

    input.addEventListener("keydown",function(e){

    if(e.key==="Enter" && !e.shiftKey){

    e.preventDefault();

    this.form.submit();

    }

    });
</script>

@endpush




