<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Weather API</title>
        <script src="{{ asset('/js/country-states.js') }}"></script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>

    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="container">
                <form method="post" action="">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <label for="country">Country</label>
                            <select id="country" name="country" class="form-control">
                                <option>select country</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-12">
                            <label for="state">State</label>
                            <span id="state-code">
                                <input type="text" id="state">
                            </span>
                        </div>
                        <button class="btn btn-info">
                            get Weather location
                        </button>
                    </div>
                </form>
            </div>

            </div>

        <script>
            // user country code for selected option
            let user_country_code = "IN";
            (function () {
                // Get the country name and state name from the imported script.
                let country_list = country_and_states['country'];
                let states_list = country_and_states['states'];

                // creating country name drop-down
                let option =  '';
                option += '<option>select country</option>';
                for(let country_code in country_list){
                    // set selected option user country
                    let selected = (country_code == user_country_code) ? ' selected' : '';
                    option += '<option value="'+country_code+'"'+selected+'>'+country_list[country_code]+'</option>';
                }
                document.getElementById('country').innerHTML = option;

                // creating states name drop-down
                let text_box = '<input type="text" class="input-text" id="state">';
                let state_code_id = document.getElementById("state-code");

                function create_states_dropdown() {
                    // get selected country code
                    let country_code = document.getElementById("country").value;
                    let states = states_list[country_code];
                    // invalid country code or no states add textbox
                    if(!states){
                        state_code_id.innerHTML = text_box;
                        return;
                    }
                    let option = '';
                    if (states.length > 0) {
                        option = '<select name="state" class="form-control" id="state">\n';
                        for (let i = 0; i < states.length; i++) {
                            option += '<option value="'+states[i].code+'">'+states[i].name+'</option>';
                        }
                        option += '</select>';
                    } else {
                        // create input textbox if no states
                        option = text_box
                    }
                    state_code_id.innerHTML = option;
                }

                // country select change event
                const country_select = document.getElementById("country");
                country_select.addEventListener('change', create_states_dropdown);

                create_states_dropdown();
            })();
        </script>

    </body>
</html>
