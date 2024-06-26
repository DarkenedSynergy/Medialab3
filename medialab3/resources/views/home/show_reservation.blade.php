<!DOCTYPE html>
<html lang="en">

<head>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
    integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  @include('home.css')
  <style type="text/css">
    .logo {
      width: 3.5rem;
    }

    .allesDiv {
      margin: 1em;
      margin-top: 0;
      border-radius: 2em;
      padding-bottom: 2em;
      padding-top: 0;
    }

    .titel {
      font-size: xx-large;
      width: fit-content;
      padding: 0.6em;
      border-radius: 0.6em;
    }

    .naamDiv {
      display: flex;
      justify-content: space-between;
      background-color: rgb(194, 194, 194);
      margin: 1em 2em 1em 2em;
      border-radius: 2em;
      height: 3em;

    }

    .naamDiv p {
      margin-top: auto;
      margin-bottom: auto;
      margin-left: 1em;
      font-size: large;
      font-weight: 600;
      color: black;
    }

    .naamDiv a:hover {
      filter: brightness(80%);
    }

    .uitleenDatum {
      margin-top: auto;
      margin-bottom: auto;
      margin-right: 0;
      text-decoration: none;
      color: white;
      background-color: #e30613;
      padding: 0.5em 1em 0.5em 1em;
      border-radius: 2em;
    }

    .uitleenDatum:last-child {
      color: white;
    }

    .rechterStuk {
      display: flex;
    }

    .verlengKnop {
      background-color: #7453fc;
      margin-top: auto;
      margin-bottom: auto;
      padding: 0.5em;
      border-radius: 0.5em;
      color: white;
      font-weight: 600;
    }

    .verlengKnop:hover {
      filter: brightness(80%);
      color: white;
    }

    .schadeKnop {
      background-color: #7453fc;
      margin-left: 0.3em;
      margin-top: auto;
      margin-bottom: auto;
      padding: 0.5em;
      border-radius: 0.5em;
      color: white;
      font-weight: 600;
    }

    .schadeKnop:hover {
      filter: brightness(80%);
      color: white;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgb(0, 0, 0);
      background-color: rgba(0, 0, 0, 0.4);
      padding-top: 60px;
    }

    .modal-content {
      background-color: #fefefe;
      margin: 5% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
    }

    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }

    .btn {
      background-color: #4CAF50;
      border: none;
      color: white;
      padding: 10px 20px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      margin: 4px 2px;
      cursor: pointer;
    }
  </style>
</head>

<body>
  @include('home.header')

  <!-- List of product reservation-->
  <div class="discover-items" style="padding-top: 140px;">
    <div class="container">
      <div class="row">

        <!-- Alert message -->
        <div>
          @if(session()->has('message'))
            <div class="alert alert-success">
            {{ session()->get('message') }}
            </div>
          @endif
        </div>
        <div class="allesDiv">
          <h1 class="titel">Mijn reserveringen</h1>

          <!-- Reservated product -->
          @foreach($data as $datas)

            <div class="lijstDiv">
            <div class="naamDiv">
              <p>{{$datas->product->Merk}} {{$datas->product->title}}</p>
              <div class="rechterStuk">
                @if($datas->extended == 1)
                  <a href="{{ route('extend.reservation', ['id' => $datas->id]) }}" class="verlengKnop" disable
                  style="filter: brightness(60%); cursor: default;">Verlengd</a>
                @else
                <a onclick="confirmation(event)" href="{{ route('extend.reservation', ['id' => $datas->id]) }}"
                class="verlengKnop">Verlengen</a>
                @endif

              <a href="" class="schadeKnop" onclick="openModal('schadeModal-{{ $datas->id }}')">Schade melden</a>
              <p class="uitleenDatum" href="#">Uitgeleend tot: {{$datas->end_date}}</p>
              </div>
            </div>
            </div>
            <div id="schadeModal-{{ $datas->id }}" class="modal">
            <div class="modal-content">
              <span class="close" onclick="closeModal('schadeModal-{{ $datas->id }}')">&times;</span>

              <!-- Form to report damage -->
              <h2>Schade melden</h2>
              <form action="{{ route('schade.melden', $datas->id) }}" method="POST">
              @csrf
              <div class="form-group">
                <label for="schadeOmschrijving-{{ $datas->id }}">Omschrijving van de schade:</label>
                <textarea class="form-control" id="schadeOmschrijving-{{ $datas->id }}" name="schadeOmschrijving"
                rows="3" required></textarea>
              </div>
              <button type="submit" class="btn">Schade melden</button>
              </form>
            </div>
            </div>
          @endforeach

        </div>
      </div>
    </div>
  </div>

  @include('home.footer')
  <script>
    function openModal(modalId) {
      event.preventDefault();
      document.getElementById(modalId).style.display = "block";
    }

    function closeModal(modalId) {
      document.getElementById(modalId).style.display = "none";
    }

    window.onclick = function (event) {
      var modals = document.getElementsByClassName("modal");
      for (var i = 0; i < modals.length; i++) {
        if (event.target == modals[i]) {
          modals[i].style.display = "none";
        }
      }
    }
  </script>
  <script type="text/javascript">
    function confirmation(ev) {
      ev.preventDefault();
      var urlToRedirect = ev.currentTarget.getAttribute('href');
      console.log(urlToRedirect);
      swal({
        title: "Ben je zeker?",
        text: "Je kan maximaal 1 keer verlengen.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
        .then((willCancel) => {
          if (willCancel) {
            window.location.href = urlToRedirect
          }
        });
    }
  </script>
  <script>
    $(document).ready(function () {
      setTimeout(function () {
        $(".alert").alert('close');
      }, 3000); // 5000 milliseconden = 5 seconden
    });
  </script>

</body>

</html>