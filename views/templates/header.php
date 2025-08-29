<!DOCTYPE html>
<html lang="en" data-theme="light">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Student Routine Dashboard</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/daisyui@5"
      media="all"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css"
      media="all"
    />
    <link rel="stylesheet" href="assets/css/dashboard.css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://code.iconify.design/3/3.1.1/iconify.min.js"></script>
  </head>
  <body class="bg-base-200 font-body min-h-screen">
    <div class="drawer">
      <input id="main-drawer" type="checkbox" class="drawer-toggle" />
      <div class="drawer-content flex flex-col min-h-screen">
        <!-- Navbar -->
        <div
          data-section-id="common_header_web"
          data-section-type="common_header"
          class="navbar bg-base-100 px-4 lg:px-10 py-4 shadow-sm sticky top-0 z-50"
        >
          <!-- Logo and Brand Section -->
          <div class="navbar-start">
            <!-- Drawer Toggle Button -->
            <label for="main-drawer" class="btn btn-ghost drawer-button">
              <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="24" height="24" viewBox="0 0 24 24" class="iconify iconify--heroicons"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path></svg>
            </label>
            
            <!-- App Title/Logo -->
        <div class="flex items-center gap-3">
          <div
            class="w-10 h-10 bg-gradient-to-br from-primary to-secondary rounded-xl flex items-center justify-center"
          >
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-mortarboard" viewBox="0 0 16 16">
              <path d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917zM8 8.46 1.758 5.965 8 3.052l6.242 2.913z"/>
              <path d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466zm-.068 1.873.22-.748 3.496 1.311a.5.5 0 0 0 .352 0l3.496-1.311.22.748L8 12.46z"/>
            </svg>
          </div>
          <div>
            <a
              class="text-xl lg:text-2xl font-heading font-bold text-primary cursor-pointer"
              onclick="navigateTo('dashboard_page')"
            >
              Student Routine Organizer
            </a>
          </div>
        </div>
      </div>
      <!-- Center - Welcome Message (Hidden on Mobile) -->
      <div class="navbar-center hidden lg:flex">
        <div class="text-center">
          <div class="text-lg font-medium text-base-content">
            <span data-time-greeting=""><?php echo htmlspecialchars($greeting); ?></span>,
            <span data-user-name="" class="text-primary font-semibold"><?php echo htmlspecialchars($username); ?></span>!
          </div>
          <div class="text-sm text-base-content/70">
            Ready to organize your day?
          </div>
        </div>
      </div>
      <!-- Right Side - User Actions -->
      <div class="navbar-end gap-2">
        <!-- Quick Access Menu (Desktop) -->
        <div class="hidden lg:flex gap-2">
          <div data-tip="Dashboard" class="tooltip">
            <button
              class="btn btn-ghost btn-sm"
              onclick="navigateTo('dashboard_page')"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true"
                role="img"
                width="20"
                height="20"
                viewBox="0 0 24 24"
                data-original='&amp;lt;span class=&quot;iconify&quot; data-icon=&quot;heroicons:home&quot; data-width=&quot;20&quot;&amp;gt;&amp;lt;/span&amp;gt;'
                class="iconify"
              >
                <path
                  fill="none"
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="1.5"
                  d="m2.25 12l8.955-8.955a1.124 1.124 0 0 1 1.59 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
                ></path>
              </svg>
            </button>
          </div>
          <div data-tip="Settings" class="tooltip">
            <button
              id="ii7bv"
              class="btn btn-ghost btn-sm ii7bv spark-custom-ii7bv ii7bv"
              onclick="navigateTo('profile_settings_page')"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true"
                role="img"
                width="20"
                height="20"
                viewBox="0 0 24 24"
                data-original='&amp;lt;span class=&quot;iconify&quot; data-icon=&quot;heroicons:cog-6-tooth&quot; data-width=&quot;20&quot;&amp;gt;&amp;lt;/span&amp;gt;'
                class="iconify"
              >
                <g
                  fill="none"
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="1.5"
                >
                  <path
                    d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87q.11.06.22.127c.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a8 8 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a7 7 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a7 7 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a7 7 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124q.108-.066.22-.128c.332-.183.582-.495.644-.869z"
                  ></path>
                  <path d="M15 12a3 3 0 1 1-6 0a3 3 0 0 1 6 0"></path>
                </g>
              </svg>
            </button>
          </div>
        </div>
        <!-- User Profile Dropdown -->
        <div
          id="iaw8h"
          class="dropdown dropdown-end iaw8h spark-custom-iaw8h iaw8h"
        >
          <div
            tabindex="0"
            role="button"
            class="btn btn-ghost btn-circle avatar"
          >
            <div
              class="avatar placeholder inline-flex items-center justify-center w-10 h-10 rounded-full bg-primary text-primary-content"
            >
              <span class="flex items-center justify-center h-full font-semibold text-lg"><?php echo htmlspecialchars($userInitial); ?></span>
            </div>
          </div>
          <ul
            tabindex="0"
            class="menu menu-sm dropdown-content mt-3 z-50 p-2 shadow bg-base-100 rounded-box w-52"
          >
            <li class="menu-title">
              <span data-user-name="" class="text-sm font-medium"><?php echo htmlspecialchars($username); ?></span>
            </li>
            <li><hr /></li>
            <li>
              <a
                id="iutxz"
                class="flex items-center gap-2 iutxz spark-custom-iutxz"
                onclick="navigateTo('profile_settings_page')"
                ><svg
                  xmlns="http://www.w3.org/2000/svg"
                  aria-hidden="true"
                  role="img"
                  width="16"
                  height="16"
                  viewBox="0 0 24 24"
                  data-original='&amp;lt;span class=&quot;iconify&quot; data-icon=&quot;heroicons:user-circle&quot; data-width=&quot;16&quot;&amp;gt;&amp;lt;/span&amp;gt;'
                  class="iconify"
                >
                  <path
                    fill="none"
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.5"
                    d="M17.982 18.725A7.49 7.49 0 0 0 12 15.75a7.49 7.49 0 0 0-5.982 2.975m11.964 0a9 9 0 1 0-11.963 0m11.962 0A8.97 8.97 0 0 1 12 21a8.97 8.97 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0a3 3 0 0 1 6 0"
                  ></path>
                </svg>
                Profile &amp; Settings
              </a>
            </li>
            <li>
              <a
                id="irt9x"
                class="flex items-center gap-2 irt9x spark-custom-irt9x"
                onclick="navigateTo('change_password_page')"
                ><svg
                  xmlns="http://www.w3.org/2000/svg"
                  aria-hidden="true"
                  role="img"
                  width="16" height="16"
                  viewBox="0 0 24 24"
                  data-original='&amp;lt;span class=&quot;iconify&quot; data-icon=&quot;heroicons:key&quot; data-width=&quot;16&quot;&amp;gt;&amp;lt;/span&amp;gt;'
                  class="iconify"
                >
                  <path
                    fill="none"
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.5"
                    d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25"
                  ></path>
                </svg>
                Change Password
              </a>
            </li>
            <li><hr /></li>
            <li>
              <a
                class="flex items-center gap-2 text-error"
                onclick="handleLogout(event)"
                href="index.php?action=logout"
                ><svg
                  xmlns="http://www.w3.org/2000/svg"
                  aria-hidden="true"
                  role="img"
                  width="16"
                  height="16"
                  viewBox="0 0 24 24"
                  data-original='&amp;lt;span class=&quot;iconify&quot; data-icon=&quot;heroicons:arrow-right-on-rectangle&quot; data-width=&quot;16&quot;&amp;gt;&amp;lt;/span&amp;gt;'
                  class="iconify"
                >
                  <path
                    fill="none"
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.5"
                    d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"
                  ></path>
                </svg>
                Logout
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>