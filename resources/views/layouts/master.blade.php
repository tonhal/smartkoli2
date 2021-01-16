<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <noscript>A böngésződ nem támogatja a JavaScript futtatását!</noscript>

    <div id="app">
        <nav id="navigation-bar" class="navbar navbar-expand-lg navbar-light bg-light mb-1">
            <div class="container">
                <router-link class="navbar-brand" to="/" exact-active-class="brand-is-active">SmartKoli</router-link>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="mr-auto navbar-nav">
                        <li class="nav-item">
                            <router-link class="nav-link" id="proba" to="/">Kezdőlap</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" to="/laundries">Mosások</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" to="/guests">Vendégek</router-link>
                        </li>
                    </ul>

                    <ul class="ml-auto navbar-nav">
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <span class='icon'><i class="fas fa-user"></i></span><span>{{ Auth::user()->name }}</span><span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    Kijelentkezés
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <transition name="fade" mode="out-in">
            <router-view :key="$route.fullPath" :user-id={{auth()->id()}}></router-view>
        </transition>
    </div>
</body>
</html>
