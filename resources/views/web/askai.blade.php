@extends('web/layouts/master')

@section('content')
    <section class="inner-banner-wrapper">
        <div class="inner-banner-wrap">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <nav class="banner-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Ask Duke Using AI</li>
                            </ol>
                        </nav>
                        <h1>Our beloved golden retriever Duke uses AI to fetch answers for you ! </h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="ask-ai-wrapper common-gap">
        <div class="container">
            <div class="row">
                  <div class="col-12 col-md-4 mb-3 mb-md-0">
                <div class="donation-left-img">
                    <img class="img-fluid" src="{{ url('assets/images/AskDuke.png') }}" alt="">
                </div>
            </div>
                <div class="col-12 col-md-8">
                    <div class="ask-ai-wrap">
                        <div class="ask-ai-title">
                            <h3>Ask Duke Using AI</h3>
                        </div>
                        <div class="ask-ai-body">
                            <div class="ask-ai-body-content" id="chat-box">
                                <!-- Messages will be shown here -->
                                <div class="AskAi-BlurBox">
                                    <p>Disclaimer:  “iPharmacy.com and its parent company do NOT guarantee the accuracy of the information displayed below.  The information below is for reference only.  You are strongly advised to consult your doctor for accurate information and any medical treatment (s). Thank you.”</p>
                                </div>
                                {{-- <img class="img-fluid" src="{{ url('assets/images/ai-generate-img.png') }}" alt=""> --}}
                            </div>

                            <div class="ask-ai-input-box">
                                <div class="ai-input">
                                    <input id="userMessage" class="form-control" type="text"
                                        placeholder=" You may ask Duke, for example: What causes arthritis ?">
                                </div>
                                <div class="ai-send-btn-wrap">
                                    <button id="sendMessageBtn" class="ai-send-btn" type="button">
                                        <img class="img-fluid" src="{{ url('assets/images/send-icon.svg') }}" alt="">
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


<script>
        const input = document.getElementById("userMessage");
        const sendBtn = document.getElementById("sendMessageBtn");
        const chatBox = document.getElementById("chat-box");

        async function sendMessage() {
            let message = input.value.trim();
            if (!message) return;


            chatBox.innerHTML += `<div><strong>You:</strong> ${message}</div>`;
            input.value = "";


            let loaderId = "loader-" + Date.now();
            chatBox.innerHTML += `<div id="${loaderId}"><em>AI is typing...</em></div>`;
            chatBox.scrollTop = chatBox.scrollHeight;

            try {
                let response = await fetch("{{ route('chat.ask') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        message: message
                    })
                });

                let data = await response.json();


                document.getElementById(loaderId).outerHTML =
                    `<div><strong>AI:</strong> ${data.reply}</div>`;

            } catch (error) {

                document.getElementById(loaderId).outerHTML =
                    `<div><strong>AI:</strong> ❌ Something went wrong</div>`;
            }

            chatBox.scrollTop = chatBox.scrollHeight;
        }

        sendBtn.addEventListener("click", sendMessage);

        input.addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                sendMessage();
            }
        });
    </script>

@endsection
