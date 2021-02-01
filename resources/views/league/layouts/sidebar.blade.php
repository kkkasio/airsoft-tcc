<aside class="navbar navbar-vertical navbar-expand-lg navbar-dark">
   <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
         <span class="navbar-toggler-icon"></span>
      </button>
      <h1 class="navbar-brand navbar-brand-autodark">
         <a href=".">
            <img src="./static/logo-white.svg" width="110" height="32" alt="Tabler" class="navbar-brand-image">
         </a>
      </h1>
      <div class="navbar-nav flex-row d-lg-none">
         <div class="nav-item dropdown d-none d-md-flex me-3">
            <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
               <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                  stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                  <path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6">
                  </path>
                  <path d="M9 17v1a3 3 0 0 0 6 0v-1"></path>
               </svg>
               <span class="badge bg-red"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-card">
               <div class="card">
                  <div class="card-body">
                     Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus ad amet consectetur
                     exercitationem fugiat in ipsa ipsum, natus odio quidem quod repudiandae sapiente. Amet
                     debitis et magni maxime necessitatibus ullam.
                  </div>
               </div>
            </div>
         </div>
         <div class="nav-item dropdown">
            <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
               aria-label="Open user menu">
               <span class="avatar avatar-sm" style="background-image: url(./static/avatars/000m.jpg)"></span>
               <div class="d-none d-xl-block ps-2">
                  <div>Paweł Kuna</div>
                  <div class="mt-1 small text-muted">UI Designer</div>
               </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
               <a href="#" class="dropdown-item">Set status</a>
               <a href="#" class="dropdown-item">Profile &amp; account</a>
               <a href="#" class="dropdown-item">Feedback</a>
               <div class="dropdown-divider"></div>
               <a href="#" class="dropdown-item">Settings</a>
               <a href="#" class="dropdown-item">Logout</a>
            </div>
         </div>
      </div>
      <div class="collapse navbar-collapse" id="navbar-menu">
         <ul class="navbar-nav pt-lg-3">
            <li class="nav-item">
               <a class="nav-link" href="{{ route('liga-dashboard') }}">
                  <span class="nav-link-icon d-md-none d-lg-inline-block"><svg xmlns="http://www.w3.org/2000/svg"
                        class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <polyline points="5 12 3 12 12 3 21 12 19 12"></polyline>
                        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"></path>
                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"></path>
                     </svg>
                  </span>
                  <span class="nav-link-title">
                     Inicio
                  </span>
               </a>
            </li>

            <li class="nav-item">
               <a class="nav-link" href="{{ route('liga-eventos') }}">
                  <span class="nav-link-icon d-md-none d-lg-inline-block"><svg xmlns="http://www.w3.org/2000/svg"
                        class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <polyline points="9 11 12 14 20 6"></polyline>
                        <path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9"></path>
                     </svg>
                  </span>
                  <span class="nav-link-title">
                     Eventos
                  </span>
               </a>
            </li>

            <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown" role="button"
                  aria-expanded="false">
                  <span class="nav-link-icon d-md-none d-lg-inline-block"><svg xmlns="http://www.w3.org/2000/svg"
                        class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path
                           d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z">
                        </path>
                     </svg>
                  </span>
                  <span class="nav-link-title">
                     Comunicados
                  </span>
               </a>
               <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{ route('liga-post-form')}}">
                     Novo Comunicado
                  </a>
                  <a class="dropdown-item" href="./gallery.html">
                     Gallery
                  </a>
                  <a class="dropdown-item" href="./wizard.html">
                     Wizard
                  </a>
               </div>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="./docs/index.html">
                  <span class="nav-link-icon d-md-none d-lg-inline-block"><svg xmlns="http://www.w3.org/2000/svg"
                        class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                        <line x1="9" y1="9" x2="10" y2="9"></line>
                        <line x1="9" y1="13" x2="15" y2="13"></line>
                        <line x1="9" y1="17" x2="15" y2="17"></line>
                     </svg>
                  </span>
                  <span class="nav-link-title">
                     Documentation
                  </span>
               </a>
            </li>
         </ul>
      </div>
   </div>
</aside>
