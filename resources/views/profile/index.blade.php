<x-layout.app>
    <div class="container">
        <div class="row mt-3">
            <form id="profileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')

                <div class="col-auto d-flex align-items-center">
                    <div class="position-relative">
                        <img id="profileImage" src="{{ asset('assets/images/profile') }}/{{ Auth::user()->image }}"
                            alt="Profile picture Gusti Purwanto" class="rounded-circle" width="100" height="100"
                            style="cursor: pointer;">

                        <input type="file" id="imageInput" name="image" accept="image/*" class="d-none"
                            onchange="submitForm()">

                        <button type="button" id="editButton"
                            class="btn btn-light border position-absolute d-flex align-items-center justify-content-center"
                            style="bottom: 0; right: 0; width: 30px; height: 40px; border-radius: 90%; aspect-ratio: 1;">
                            <i class="fas fa-pencil-alt text-gray-500"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="mt-3">
            <h1 class="h4 font-weight-bold mb-0">{{ Auth::user()->name }}</h1>
        </div>

        <div class="row mt-4">
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Nama Kandidat</label>
                <div class="position-relative">
                    <i class="fas fa-at position-absolute top-50 start-0 translate-middle-y text-muted ms-2"></i>
                    <x-input name="search" placeholder="Nama Kandidat" value="{{ Auth::user()->name }}"
                        class="custom-class" style="padding-left: 35px;" disabled />
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Posisi Kandidat</label>
                <div class="position-relative">
                    <i class="fas fa-code position-absolute top-50 start-0 translate-middle-y text-muted ms-2"></i>
                    <x-input name="search" placeholder="Posisi Kandidat" value="{{ Auth::user()->position }}"
                        class="custom-class" style="padding-left: 35px;" disabled />
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            document.getElementById('profileImage').addEventListener('click', function() {
                document.getElementById('imageInput').click();
            });

            document.getElementById('editButton').addEventListener('click', function() {
                document.getElementById('imageInput').click();
            });

            function submitForm() {
                document.getElementById('profileForm').submit();
            }
        </script>
    @endpush
</x-layout.app>
