<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <ul id="users" class="list-disc">
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const getUsers = async () => {
            const { data } = await window.axios.get("/api/users");

            const usersElement = document.getElementById("users");

            data.forEach(user => {
                const li = document.createElement("li");

                li.setAttribute("id", user.id);
                li.innerText = user.name;

                usersElement.appendChild(li);
            });
        };

        getUsers();
    </script>

    <script>
        window.Echo.channel("users")
            .listen("UserCreated", (e) => {
                const usersElement = document.getElementById("users");

                const li = document.createElement("li");

                li.setAttribute("id", e.user.id);
                li.innerText = e.user.name;

                usersElement.appendChild(li);
            })
            .listen("UserUpdated", (e) => {
                const userElement = document.getElementById(e.user.id);

                userElement.innerText = e.user.name;
            })
            .listen("UserDeleted", (e) => {
                const userElement = document.getElementById(e.user.id);

                userElement.remove();
            });
    </script>
    @endpush
</x-app-layout>
