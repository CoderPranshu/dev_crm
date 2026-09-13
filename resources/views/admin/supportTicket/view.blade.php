@extends('index')
@push('title', get_phrase('Support Ticket'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Support Ticket') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="{{ route('admin.support.index') }}">{{ get_phrase('Support') }}</a></li>
                    <li><a href="#">{{ get_phrase('Support Ticket Details') }}</a></li>
                </ul>
            </div>
            <div class="export-btn-area">
                <a href="#"
                    onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/supportTicket/add']) }}', '{{ get_phrase('Add new support ticket') }}')"
                    class="export_btn">
                    <i class="bi bi-plus"></i>
                    <span class="d-none d-sm-inline-block">{{ get_phrase('Add new support ticket') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <p class="column-title mb-2">{{ get_phrase('Support Ticket') }}</p>
                <div class="card">
                    <div class="card-header">
                        <h5 class="eForm-label">{{ $ticket->subject }}</h5>
                        <span class="badge bg-primary eForm-label text-white">{{ strtoupper($ticket->status) }}</span>
                    </div>

                    <div class="card-body" id="chatBox" style="max-height:400px; overflow-y:auto;">
                        @foreach ($ticket->message as $msg)
                            <div class="mb-2 eForm-label {{ $msg->sender_type == 'user' ? 'text-start' : 'text-end' }}">
                                <div
                                    class="p-2 rounded d-inline-block
                    {{ $msg->sender_type == 'user' ? 'bg-light' : 'bg-primary text-white' }}">
                                    <strong>{{ $msg->sender->name }}</strong><br>
                                    {{ $msg->message }}
                                    <div class="small text-muted">{{ $msg->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="card-footer">
                        @if ($ticket->status != 'closed')
                            {{-- <form id="replyForm" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="support_ticket_id" value="{{ $ticket->id }}">

                                <div class="input-group">
                                    <input type="text" name="message" id="messageInput"
                                        class="eForm-control form-control"
                                        placeholder="{{ get_phrase('Type your reply...') }}" required>
                                    <input type="file" name="attachment" id="attachment">
    
                                    <button class="btn-form btn-success">{{ get_phrase('Send') }}</button>
                                </div>
                            </form> --}}

                            <form id="replyForm" enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="support_ticket_id" value="{{ $ticket->id }}">

                                <div class="input-group">
                                    <input type="text"
                                        name="message"
                                        id="messageInput"
                                        class="eForm-control form-control"
                                        placeholder="Type your reply...">
                                    
                                     <label for="attachment" class="btn btn-light border mb-0">
                                        <i class="bi bi-paperclip"></i>
                                    </label>
                                    
                                     <input type="file"
                                        name="attachment"
                                        id="attachment"
                                        hidden>

                                    {{-- <input type="file" name="attachment"> --}}

                                    <button type="submit" class="btn-form btn-success">
                                        Send
                                    </button>
                                </div>

                                <small id="fileName" class="text-muted"></small>
                            </form>

                        @endif
                    </div>
                </div>
                @if ($ticket->status != 'closed')
                    <form action="{{ route('admin.support.closeTicket', $ticket->id) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-primary my-3 btn-sm">Close Ticket</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $('#attachment').on('change', function() {

            let fileName = this.files[0]?.name || '';

            $('#fileName').text(fileName);
        });
        // $('#replyForm').submit(function(e) {
        //     e.preventDefault();

        //     $.ajax({
        //         url: "{{ route('admin.support.reply') }}",
        //         method: "POST",
        //         data: $(this).serialize(),
        //         success: function() {
        //             $('#messageInput').val('');
        //             loadMessages();
        //             window.location.reload();
        //         }
        //     });
        // });

       $('#replyForm').submit(function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('admin.support.reply') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,

                success: function(response) {
                    $('#messageInput').val('');
                    $('input[name="attachment"]').val('');
                    loadMessages();
                }
            });
        });

        // function loadMessages() {
        //     $.get("{{ url('/support/fetch/' . $ticket->id) }}", function(data) {
        //         let html = '';
        //         data.forEach(msg => {
        //             html += `
        //         <div class="mb-2 ${msg.sender_type == 'user' ? 'text-start' : 'text-end'}">
        //             <div class="p-2 rounded d-inline-block
        //                 ${msg.sender_type == 'user' ? 'bg-light' : 'bg-primary text-white'}">
        //                 <strong>${msg.sender.name}</strong><br>
        //                 ${msg.message}
        //             </div>
        //         </div>`;
        //         });
        //         $('#chatBox').html(html);
        //     });
        // }

        function loadMessages() {

           $.get("{{ route('admin.support.fetch', $ticket->id) }}", function(data) {

                let html = '';

                data.forEach(msg => {

                    let attachment = '';

                    if (msg.attachment) {

                        console.log(msg.attachment);

                        let ext = msg.attachment.split('.').pop().toLowerCase();

                        if (['jpg','jpeg','png','gif','webp'].includes(ext)) {

                            // attachment = `
                            //     <br>
                            //     <img src="/${msg.attachment}"
                            //         style="max-width:200px;margin-top:10px;">
                            // `;

                            attachment = `
                                <br>
                                <img src="{{ url('/') }}/public/${msg.attachment}"
                                    style="max-width:200px;margin-top:10px;">
                            `;

                        } else {

                            let fileName = msg.attachment.split('/').pop();
                            fileName = fileName.replace(/^\d+_/, '');

                            attachment = `
                                <br>
                                <a href="/public/${msg.attachment}" target="_blank" style="color: white; width: 500px;">
                                    ${fileName}
                                </a>
                            `;
                        }
                    }

                    html += `
                        <div class="mb-2 ${msg.sender_type == 'user' ? 'text-start' : 'text-end'}">
                            <div class="p-2 rounded d-inline-block ${msg.sender_type == 'user' ? 'bg-light' : 'bg-primary text-white'}">
                                <strong>${msg.sender.name}</strong><br>
                                ${msg.message ?? ''}
                                ${attachment}
                            </div>
                        </div>
                    `;
                });

                $('#chatBox').html(html);

                $('#chatBox').scrollTop(
                    $('#chatBox')[0].scrollHeight
                );
              

                
            });
        }


        setInterval(loadMessages, 3000);
    </script>

@endpush