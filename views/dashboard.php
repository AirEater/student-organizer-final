<main id="ia6rh" class="flex-grow ia6rh spark-custom-ia6rh ia6rh">
      <section
        id="WelcomeAndModulesSection"
        class="w-full max-w-screen-xl mx-auto px-6 md:px-8 py-10 WelcomeAndModulesSection spark-custom-WelcomeAndModulesSection"
      >
        <!-- Welcome Header &amp; Quote -->
        <div class="mb-12">
          <h1
            class="font-heading text-3xl md:text-4xl lg:text-5xl font-bold text-base-content"
          >
            <span data-time-greeting=""><?php echo htmlspecialchars($greeting); ?></span>,
            <span data-user-name="" class="text-primary"><?php echo htmlspecialchars($username); ?></span>!
          </h1>
          <figure class="mt-6 pl-4 border-l-4 border-base-300">
            <blockquote class="italic text-base-content/80 text-lg" id="dynamicQuote">
              "The secret of getting ahead is getting started."
            </blockquote>
            <figcaption
              class="text-right text-base-content/60 mt-2 i4o9fr spark-custom-i4o9fr"
              id="dynamicAuthor"
            >
              — Mark Twain
            </figcaption>
          </figure>
        </div>
        <!-- Modules Grid -->
        <div
          class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8"
        >
          <!-- Exercise Card -->
          <div
            data-repeatable="true"
            class="card bg-base-100 shadow-soft shadow-hover overflow-hidden"
          >
            <div class="card-body p-6 flex flex-col">
              <div class="flex-grow">
                <div class="flex justify-between items-start mb-4">
                  <div
                    class="w-12 h-12 rounded-full flex items-center justify-center bg-exercise-light"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      aria-hidden="true"
                      role="img"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      data-original='&amp;lt;span class=&quot;iconify&quot; data-icon=&quot;heroicons:bolt&quot; data-width=&quot;24&quot;&amp;gt;&amp;lt;/span&amp;gt;'
                      class="iconify text-exercise"
                    >
                      <path
                        fill="none"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.5"
                        d="m3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75L12 13.5z"
                      ></path>
                    </svg>
                  </div>
                  <div
                    class="badge badge-outline border-exercise-light text-exercise font-medium"
                  >
                    2/5 tasks done
                  </div>
                </div>
                <h3 class="card-title font-heading text-xl">
                  Exercise Tracker
                </h3>
                <p class="text-base-content/70 mt-1">
                  Log your workouts and monitor your fitness progress.
                </p>
              </div>
              <div class="card-actions mt-6">
                <button
                  class="btn btn-primary w-full gap-2"
                  onclick="window.location.href='ExerciseTracker/index.php'"
                >
                  <span>Go</span
                  ><svg
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                    role="img"
                    width="16"
                    height="16"
                    viewBox="0 0 24 24"
                    data-original='&amp;lt;span class=&quot;iconify&quot; data-icon=&quot;heroicons:arrow-right&quot; data-width=&quot;16&quot;&amp;gt;&amp;lt;/span&amp;gt;'
                    class="iconify"
                  >
                    <path
                      fill="none"
                      stroke="currentColor"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="1.5"
                      d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"
                    ></path>
                  </svg>
                </button>
              </div>
            </div>
          </div>
          <!-- Diary Card -->
          <div
            data-repeatable="true"
            class="card bg-base-100 shadow-soft shadow-hover overflow-hidden"
          >
            <div class="card-body p-6 flex flex-col">
              <div class="flex-grow">
                <div class="flex justify-between items-start mb-4">
                  <div
                    class="w-12 h-12 rounded-full flex items-center justify-center bg-diary-light"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      aria-hidden="true"
                      role="img"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      data-original='&amp;lt;span class=&quot;iconify&quot; data-icon=&quot;heroicons:book-open&quot; data-width=&quot;24&quot;&amp;gt;&amp;lt;/span&amp;gt;'
                      class="iconify"
                    >
                      <path
                        fill="none"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.5"
                        d="M12 6.042A8.97 8.97 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A9 9 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.97 8.97 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A9 9 0 0 0 18 18a8.97 8.97 0 0 0-6 2.292m0-14.25v14.25"
                      ></path>
                    </svg>
                  </div>
                  <div
                    class="badge badge-outline border-diary-light text-diary font-medium"
                  >
                    1 new entry
                  </div>
                </div>
                <h3 class="card-title font-heading text-xl">Diary Journal</h3>
                <p class="text-base-content/70 mt-1">
                  Reflect on your day and organize your thoughts.
                </p>
              </div>
              <div class="card-actions mt-6">
                <button
                  class="btn btn-primary w-full gap-2"
                  onclick="window.location.href='DiaryJournal/diary.php'"
                >
                  <span>Go</span
                  ><svg
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                    role="img"
                    width="16"
                    height="16"
                    viewBox="0 0 24 24"
                    data-original='&amp;lt;span class=&quot;iconify&quot; data-icon=&quot;heroicons:arrow-right&quot; data-width=&quot;16&quot;&amp;gt;&amp;lt;/span&amp;gt;'
                    class="iconify"
                  >
                    <path
                      fill="none"
                      stroke="currentColor"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="1.5"
                      d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"
                    ></path>
                  </svg>
                </button>
              </div>
            </div>
          </div>
          <!-- Money Card -->
          <div
            data-repeatable="true"
            class="card bg-base-100 shadow-soft shadow-hover overflow-hidden"
          >
            <div class="card-body p-6 flex flex-col">
              <div class="flex-grow">
                <div class="flex justify-between items-start mb-4">
                  <div
                    class="w-12 h-12 rounded-full flex items-center justify-center bg-money-light"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      aria-hidden="true"
                      role="img"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      data-original='&amp;lt;span class=&quot;iconify&quot; data-icon=&quot;heroicons:banknotes&quot; data-width=&quot;24&quot;&amp;gt;&amp;lt;/span&amp;gt;'
                      class="iconify"
                    >
                      <path
                        fill="none"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.5"
                        d="M2.25 18.75a60 60 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0a3 3 0 0 1 6 0m3 0h.008v.008H18zm-12 0h.008v.008H6z"
                      ></path>
                    </svg>
                  </div>
                  <div
                    class="badge badge-outline border-money-light text-money font-medium"
                  >
                    In budget
                  </div>
                </div>
                <h3 class="card-title font-heading text-xl">Money Tracker</h3>
                <p class="text-base-content/70 mt-1">
                  Manage your budget and track all your expenses.
                </p>
              </div>
              <div class="card-actions mt-6">
                <button
                  class="btn btn-primary w-full gap-2"
                  onclick="window.location.href='money.php'"
                >
                  <span>Go</span
                  ><svg
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                    role="img"
                    width="16"
                    height="16"
                    viewBox="0 0 24 24"
                    data-original='&amp;lt;span class=&quot;iconify&quot; data-icon=&quot;heroicons:arrow-right&quot; data-width=&quot;16&quot;&amp;gt;&amp;lt;/span&amp;gt;'
                    class="iconify"
                  >
                    <path
                      fill="none"
                      stroke="currentColor"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="1.5"
                      d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"
                    ></path>
                  </svg>
                </button>
              </div>
            </div>
          </div>
          <!-- Habit Card -->
          <div
            data-repeatable="true"
            class="card bg-base-100 shadow-soft shadow-hover overflow-hidden"
          >
            <div
              class="card-body p-6 flex flex-col irpyzz spark-custom-irpyzz"
              id="irpyzz"
            >
              <div class="flex-grow i7tqom spark-custom-i7tqom" id="i7tqom">
                <div class="flex justify-between items-start mb-4">
                  <div
                    class="w-12 h-12 rounded-full flex items-center justify-center bg-habit-light"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      aria-hidden="true"
                      role="img"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      data-original='&amp;lt;span class=&quot;iconify&quot; data-icon=&quot;heroicons:check-badge&quot; data-width=&quot;24&quot;&amp;gt;&amp;lt;/span&amp;gt;'
                      class="iconify"
                    >
                      <path
                        fill="none"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.5"
                        d="M9 12.75L11.25 15L15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.75 3.75 0 0 1-1.043 3.296a3.75 3.75 0 0 1-3.296 1.043A3.75 3.75 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.75 3.75 0 0 1-3.296-1.043a3.75 3.75 0 0 1-1.043-3.296A3.75 3.75 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.75 3.75 0 0 1 1.043-3.296a3.75 3.75 0 0 1 3.296-1.043A3.75 3.75 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.75 3.75 0 0 1 3.296 1.043a3.75 3.75 0 0 1 1.043 3.296A3.75 3.75 0 0 1 21 12"
                      ></path>
                    </svg>
                  </div>
                  <div
                    class="badge badge-outline border-habit-light text-habit font-medium"
                  >
                    80% streak
                  </div>
                </div>
                <h3 class="card-title font-heading text-xl">Habit Tracker</h3>
                <p class="text-base-content/70 mt-1">
                  Build good habits and break the bad ones consistently.
                </p>
              </div>
              <div class="card-actions mt-6">
                <button
                  class="btn btn-primary w-full gap-2"
                  onclick="window.location.href='HabitTracker/habit_page.php'"
                >
                  <span>Go</span
                  ><svg
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                    role="img"
                    width="16"
                    height="16"
                    viewBox="0 0 24 24"
                    data-original='&amp;lt;span class=&quot;iconify&quot; data-icon=&quot;heroicons:arrow-right&quot; data-width=&quot;16&quot;&amp;gt;&amp;lt;/span&amp;gt;'
                    class="iconify"
                  >
                    <path
                      fill="none"
                      stroke="currentColor"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="1.5"
                      d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"
                    ></path>
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>

    <script>
  // simple client-side router for the dashboard cards
  (function () {
    if (typeof window.navigateTo === 'function') return; // don’t redefine

    window.navigateTo = function (key) {
      const routes = {
        exercise_tracker_page: '/login_dashboard/student_organizer/ExerciseTracker/index.php',
        // fill these later if/when those modules exist:
        diary_journal_page: '/login_dashboard/student_organizer/DiaryJournal/diary.php',
        money_tracker_page: '#',
        habit_tracker_page: '#'
      };

      const href = routes[key];
      if (!href) return console.warn('Unknown route:', key);
      if (href === '#') return console.warn('Route not implemented:', key);
      window.location.href = href; // relative to /student_organizer/
    };
  })();
</script>

