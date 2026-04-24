<x-app-layout>
  <div class="container">
    <div class="page-inner">
      <div class="row">
        <div class="col-md-12">

          <div class="card">

            <div class="card-header">
              <div class="card-title">Create Complexion</div>
            </div>

            <form action="{{ route('complexion.store') }}" method="post">
              @csrf

              <div class="card-body">

                <div class="row">

                  <div class="col-md-12">

                    <x-form-input type="text" id="complexion_name" label="Complexion Title" name="name"
                      :value="old('name')" placeholder="Enter Complexion Title" />

                    <x-form-input type="text" id="hindi_name" label="Complexion Hindi Title" name="hindi_name"
                      :value="old('hindi_name')" readonly placeholder="Hindi title auto generated" />

                    <x-status-select id="statusSelect" name="status" :selected="old('status')" />

                  </div>

                </div>

              </div>

              <div class="card-action">
                <button class="btn btn-success" type="submit">
                  Submit
                </button>
              </div>

            </form>

          </div>

        </div>
      </div>
    </div>
  </div>
</x-app-layout>

<script>
  document.addEventListener('DOMContentLoaded', function () {

    const englishInput = document.getElementById('complexion_name');
    const hindiInput = document.getElementById('hindi_name');

    englishInput.addEventListener('input', function () {

      const text = this.value;

      if (!text || text.trim() === '') {
        hindiInput.value = '';
        return;
      }

      fetch(`https://translate.googleapis.com/translate_a/single?client=gtx&sl=en&tl=hi&dt=t&q=${encodeURIComponent(text)}`)
        .then(response => response.json())
        .then(data => {
          hindiInput.value = data[0][0][0];
        })
        .catch(error => {
          console.log(error);
        });

    });

  });
</script>