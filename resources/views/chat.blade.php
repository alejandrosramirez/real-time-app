<x-app-layout>
    @push('styles')
    <style>
        #online > li {
            cursor: pointer;
        }
    </style>
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- tailwind grid --}}
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-10">
                            <div class="row-auto">
                                <div class="border rounded-lg p-3">
                                    <ul id="messages" class="list-none overflow-auto" style="height: 45vh;">
                                        {{-- <li>JAJA</li>
                                        <li>JAJA</li>
                                        <li>JAJA</li>
                                        <li>JAJA</li> --}}
                                    </ul>
                                </div>
                            </div>
                            <form class="py-3">
                                <div class="grid grid-cols-12 gap-4">
                                    <div class="col-span-10">
                                        <input id="message" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Message..." />
                                    </div>
                                    <div class="col-span-2">
                                        <button id="send" type="submit" class="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded w-full">
                                            Send
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-span-2">
                            <div class="row-auto mx-5">
                                <p><b>Online now</b></p>

                                <ul id="online" class="list-decimal" style="height: 45vh;">
                                    {{-- <li class="text-green-400">l</li>
                                    <li class="text-green-400">l</li>
                                    <li class="text-green-400">l</li>
                                    <li class="text-green-400">l</li> --}}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const messagesElement = document.getElementById("messages");
        const onlineElement = document.getElementById("online");

        window.Echo.join("chat")
            .here((users) => {
                users.forEach(user => {
                    const li = document.createElement("li");

                    li.setAttribute("id", user.id);
                    li.setAttribute("onclick", `greetUser('${user.id}')`)
                    li.classList.add("text-green-400");
                    li.innerText = user.name;

                    onlineElement.appendChild(li);
                });
            })
            .joining((user) => {
                const li = document.createElement("li");

                li.setAttribute("id", user.id);
                li.setAttribute("onclick", `greetUser('${user.id}')`)
                li.classList.add("text-green-400");
                li.innerText = user.name;

                onlineElement.appendChild(li);
            })
            .leaving((user) => {
                const userElement = document.getElementById(user.id);

                userElement.remove();
            })
            .listen("MessageSent", (e) => {
                const li = document.createElement("li");

                li.innerText = `${e.user.name}: ${e.message}`;

                messagesElement.appendChild(li);
            });
    </script>

    <script>
        const sendElement = document.getElementById("send");
        const messageElement = document.getElementById("message");

        sendElement.addEventListener("click", async (event) => {
            event.preventDefault();

            try {
                const message = messageElement.value;

                if (message.length === 0) {
                    return;
                }

                const { data } = await axios.post("/chat", {
                    message,
                });
            } catch (error) {
                console.log(error);
            }

            messageElement.value = "";
        });
    </script>

    <script>
        const greetUser = async (id) => {
            try {
               const { data } = await window.axios.post(`/chat/greet/${id}`);
            } catch (error) {
                console.log(error);
            }
        };
    </script>

    <script>
        window.Echo.private("chat.greet.{{ auth()->user()->id }}")
            .listen("GreetingSent", (e) => {
                const li = document.createElement("li");

                li.classList.add("text-blue-600");
                li.innerText = `${e.message}`;

                messagesElement.appendChild(li);
            });
    </script>
    @endpush
</x-app-layout>
