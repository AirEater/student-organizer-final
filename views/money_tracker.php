<?php
// Helper function to get icon path and color based on category
function get_category_icon($category) {
    $icons = [
        'Food' => ['path' => 'M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007M8.625 10.5a.375.375 0 1 1-.75 0a.375.375 0 0 1 .75 0m7.5 0a.375.375 0 1 1-.75 0a.375.375 0 0 1 .75 0', 'color' => 'text-orange-500'],
        'Education' => ['path' => 'M4.26 10.147a60 60 0 0 0-.491 6.347A48.6 48.6 0 0 1 12 20.904a48.6 48.6 0 0 1 8.232-4.41a61 61 0 0 0-.491-6.347m-15.482 0a51 51 0 0 0-2.658-.813A60 60 0 0 1 12 3.493a60 60 0 0 1 10.399 5.84q-1.345.372-2.658.814m-15.482 0A51 51 0 0 1 12 13.489a50.7 50.7 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5a.75.75 0 0 0 0 1.5m0 0v-3.675A55 55 0 0 1 12 8.443m-7.007 11.55A5.98 5.98 0 0 0 6.75 15.75v-1.5', 'color' => 'text-blue-500'],
        'Entertainment' => ['path' => 'M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h1.5C5.496 19.5 6 18.996 6 18.375m-3.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-1.5A1.125 1.125 0 0 1 18 18.375M20.625 4.5H3.375m17.25 0c.621 0 1.125.504 1.125 1.125M20.625 4.5h-1.5C18.504 4.5 18 5.004 18 5.625m3.75 0v1.5c0 .621-.504 1.125-1.125 1.125M3.375 4.5c-.621 0-1.125.504-1.125 1.125M3.375 4.5h1.5C5.496 4.5 6 5.004 6 5.625m-3.75 0v1.5c0 .621.504 1.125 1.125 1.125m0 0h1.5m-1.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m1.5-3.75C5.496 8.25 6 7.746 6 7.125v-1.5M4.875 8.25C5.496 8.25 6 8.754 6 9.375v1.5m0-5.25v5.25m0-5.25C6 5.004 6.504 4.5 7.125 4.5h9.75c.621 0 1.125.504 1.125 1.125m1.125 2.625h1.5m-1.5 0A1.125 1.125 0 0 1 18 7.125v-1.5m1.125 2.625c-.621 0-1.125.504-1.125 1.125v1.5m2.625-2.625c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125M18 5.625v5.25M7.125 12h9.75m-9.75 0A1.125 1.125 0 0 1 6 10.875M7.125 12C6.504 12 6 12.504 6 13.125m0-2.25C6 11.496 5.496 12 4.875 12M18 10.875c0 .621-.504 1.125-1.125 1.125M18 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m-12 5.25v-5.25m0 5.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125m-12 0v-1.5c0-.621-.504-1.125-1.125-1.125M18 18.375v-5.25m0 5.25v-1.5c0-.621.504-1.125 1.125-1.125M18 13.125v1.5c0 .621.504 1.125 1.125 1.125M18 13.125c0-.621.504-1.125 1.125-1.125M6 13.125v1.5c0 .621-.504-1.125-1.125 1.125M6 13.125C6 12.504 5.496 12 4.875 12m-1.5 0h1.5m-1.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125', 'color' => 'text-purple-500'],
        'Transportation' => ['path' => 'M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.9 17.9 0 0 0-3.213-9.193a2.06 2.06 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.6 48.6 0 0 0-10.026 0a1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12', 'color' => 'text-green-500'],
        'Income' => ['path' => 'M2.25 18.75a60 60 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0a3 3 0 0 1 6 0m3 0h.008v.008H18zm-12 0h.008v.008H6z', 'color' => 'text-success'],
        'Default' => ['path' => 'M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007M8.625 10.5a.375.375 0 1 1-.75 0a.375.375 0 0 1 .75 0m7.5 0a.375.375 0 1 1-.75 0a.375.375 0 0 1 .75 0', 'color' => 'text-error']
    ];
    return $icons[$category] ?? $icons['Default'];
}
?>
<!-- Money Tracker Specific Styles -->
<style>
    .money-gradient {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.1) 0%, rgba(16, 185, 129, 0.1) 100%);
    }
    .financial-card:hover {
        border-color: var(--color-money);
        box-shadow: 0 8px 25px rgba(34, 197, 94, 0.15);
    }
    .transaction-item:hover {
        background-color: var(--color-base-200);
        transform: translateX(4px);
    }
    .tab-content {
        display: none;
    }
    input[type="radio"]:checked + .tab-content {
        display: block;
    }
</style>

<!-- Main Content -->
<main id="main-content-top" class="flex-grow p-6">
    <section id="money_tracker_overview" class="bg-gradient-to-br from-green-50 to-emerald-100 py-16">
        <div class="container mx-auto px-6 lg:px-20">
          <!-- Back to Dashboard Button -->
          <div class="mb-8">
  <div class="flex items-center gap-4 mb-6">
    <!-- Back to Dashboard (left) -->
    <button class="btn btn-ghost gap-2 text-base-content/70 hover:text-base-content"
            onclick="navigateTo('dashboard_page')">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                  <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
                Back to Dashboard
              </button>

              <!-- Month Navigation (right) -->
              <?php $anchor = '#main-content-top'; ?>
              <div class="ml-auto flex items-center gap-4">
                <a href="<?php echo $prev_month_link . $anchor; ?>" class="btn btn-ghost">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"></polyline>
                  </svg>
                </a>

                <button id="month-picker-button"
                        class="text-xl font-bold text-center cursor-pointer hover:text-primary transition-colors">
                  <?php echo htmlspecialchars($display_month_year); ?>
                </button>

                <a href="<?php echo $next_month_link . $anchor; ?>" class="btn btn-ghost">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                  </svg>
                </a>
              </div>
            </div>

            <!-- Month Picker Modal (unchanged) -->
            <div id="month-picker-modal"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
              <div class="bg-base-100 p-6 rounded-lg shadow-xl w-full max-w-xs relative">
                <div class="flex items-center justify-between mb-4">
                  <button id="prev-year" class="btn btn-ghost btn-sm">&lt;</button>
                  <h4 id="picker-year" class="font-bold text-lg"><?php echo $currentYear; ?></h4>
                  <button id="next-year" class="btn btn-ghost btn-sm">&gt;</button>
                </div>
                <div id="month-grid" class="grid grid-cols-3 gap-2">
                  <?php
                  for ($m = 1; $m <= 12; $m++) {
                      $month_name = date('M', mktime(0, 0, 0, $m, 10));
                      $is_current = ($m == $currentMonth && $currentYear == date('Y')) ? 'btn-primary' : 'btn-ghost';
                      echo sprintf('<button data-month="%d" class="month-button btn %s btn-sm">%s</button>',
                                  $m, $is_current, $month_name);
                  }
                  ?>
                </div>
                <button id="close-picker" class="btn btn-sm btn-circle btn-ghost absolute top-2 right-2">✕</button>
              </div>
            </div>
          </div>
          <!-- Page Title -->
          <div class="text-center mb-12">
            <h1 class="text-4xl lg:text-5xl font-bold text-money mb-4">
              Money Tracker
            </h1>
            <p class="text-lg text-base-content/70 max-w-2xl mx-auto">
              Monitor your income, expenses, and overall balance with smart
              categorization and budgeting tools
            </p>
          </div>
          <!-- Balance View Toggle -->
          <div class="text-center mb-8">
              <div class="join">
                  <a href="money.php?month=<?php echo $currentMonth; ?>&year=<?php echo $currentYear; ?>&balance_view=monthly" 
                     class="join-item btn <?php echo ($balance_view === 'monthly') ? 'btn-primary' : ''; ?>">
                      Monthly Balance
                  </a>
                  <a href="money.php?month=<?php echo $currentMonth; ?>&year=<?php echo $currentYear; ?>&balance_view=accumulated" 
                     class="join-item btn <?php echo ($balance_view === 'accumulated') ? 'btn-primary' : ''; ?>">
                      Accumulated Balance
                  </a>
              </div>
          </div>

          <!-- Financial Overview Cards -->
          <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <!-- Total Balance Card -->
            <div class="card bg-base-100 shadow-soft hover:shadow-hover transition-all duration-300">
              <div class="card-body text-center">
                <div class="flex items-center justify-center mb-4">
                  <div class="w-16 h-16 rounded-full bg-money/20 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="32" height="32" viewBox="0 0 24 24" data-icon="heroicons:banknotes" data-width="32" class="iconify text-money iconify--heroicons"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 18.75a60 60 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0a3 3 0 0 1 6 0m3 0h.008v.008H18zm-12 0h.008v.008H6z"></path></svg>
                  </div>
                </div>
                <h3 class="text-lg font-semibold text-base-content/70 mb-2">
                  <?php echo ($balance_view === 'monthly') ? 'Monthly Balance' : 'Accumulated Balance'; ?>
                </h3>
                <div class="text-3xl font-bold text-money">RM<?php echo isset($display_balance) ? number_format($display_balance, 2) : '0.00'; ?></div>
              </div>
            </div>
            <!-- Total Income Card -->
            <div class="card bg-base-100 shadow-soft hover:shadow-hover transition-all duration-300">
              <div class="card-body text-center">
                <div class="flex items-center justify-center mb-4">
                  <div class="w-16 h-16 rounded-full bg-success/20 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="32" height="32" viewBox="0 0 24 24" data-icon="heroicons:arrow-trending-up" data-width="32" class="iconify text-success iconify--heroicons"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 18L9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0l-5.94-2.281m5.94 2.28l-2.28 5.942"></path></svg>
                  </div>
                </div>
                <h3 class="text-lg font-semibold text-base-content/70 mb-2">
                  Total Income
                </h3>
                <div class="text-3xl font-bold text-success">RM<?php echo isset($summary['total_income']) ? number_format($summary['total_income'], 2) : '0.00'; ?></div>
              </div>
            </div>
            <!-- Total Expenses Card -->
            <div class="card bg-base-100 shadow-soft hover:shadow-hover transition-all duration-300">
              <div class="card-body text-center">
                <div class="flex items-center justify-center mb-4">
                  <div class="w-16 h-16 rounded-full bg-error/20 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="32" height="32" viewBox="0 0 24 24" data-icon="heroicons:arrow-trending-down" data-width="32" class="iconify text-error iconify--heroicons"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 6L9 12.75l4.286-4.286a11.95 11.95 0 0 1 4.306 6.43l.776 2.898m0 0l3.182-5.511m-3.182 5.51l-5.511-3.181"></path></svg>
                  </div>
                </div>
                <h3 class="text-lg font-semibold text-base-content/70 mb-2">
                  Total Expenses
                </h3>
                <div class="text-3xl font-bold text-error">RM<?php echo isset($summary['total_expense']) ? number_format($summary['total_expense'], 2) : '0.00'; ?></div>
              </div>
            </div>
          </div>
          <!-- Action Button -->
          <div class="text-center">
            <button class="btn btn-primary btn-lg gap-2 shadow-hover" onclick="window.location.href='money.php?action=add_form'">
              <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="20" height="20" viewBox="0 0 24 24" data-icon="heroicons:plus" data-width="20" class="iconify iconify--heroicons"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.5v15m7.5-7.5h-15"></path></svg>
              Add New Transaction
            </button>
          </div>
        </div>
      </section>

    <!-- Main Content Layout -->
    <section id="main_content_layout" class="flex-1 py-16 main_content_layout spark-custom-main_content_layout">
        <div class="container mx-auto px-6 lg:px-20">
          <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Left Sidebar -->
            <div class="lg:col-span-1">
              <!-- Budget Categories -->
              <div class="card bg-base-100 shadow-soft mb-8">
                <div class="card-body">
                  <h3 class="card-title text-lg mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="20" height="20" viewBox="0 0 24 24" data-icon="heroicons:squares-2x2" data-width="20" class="iconify text-primary iconify--heroicons"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25zm0 9.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18zM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25zm0 9.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18z"></path></svg>
                    Budget Categories
                  </h3>
                  <div class="space-y-4">
                    <?php if (empty($budgets)): ?>
                      <div class="text-center text-base-content/60 py-4">No budgets set for this month.</div>
                    <?php else: ?>
                      <?php foreach ($budgets as $budget): ?>
                        <?php 
                          $icon = get_category_icon($budget['category_name']);
                          $spent = $budget['spent'] ?? 0;
                          $amount = $budget['amount'];
                          $percentage = ($amount > 0) ? ($spent / $amount) * 100 : 0;
                        ?>
                        <div class="flex items-center justify-between p-3 bg-base-200 rounded-lg">
                          <div class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="20" height="20" viewBox="0 0 24 24" class="iconify <?php echo $icon['color']; ?>"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="<?php echo $icon['path']; ?>"></path></svg>
                            <span class="font-medium"><?php echo htmlspecialchars($budget['category_name']); ?></span>
                          </div>
                          <div class="text-right">
                            <div class="text-sm font-semibold">RM<?php echo number_format($spent, 2); ?> / RM<?php echo number_format($amount, 2); ?></div>
                            <div class="text-xs text-base-content/60"><?php echo round($percentage); ?>% used</div>
                          </div>
                        </div>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
              <!-- Quick Budget Setup -->
              <div class="card bg-base-100 shadow-soft">
                <div class="card-body">
                  <h3 class="card-title text-lg mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="20" height="20" viewBox="0 0 24 24" data-icon="heroicons:bolt" data-width="20" class="iconify text-accent iconify--heroicons"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75L12 13.5z"></path></svg>
                    Quick Budget
                  </h3>
                  <form action="money.php?action=set_budget" method="POST">
                    <input type="hidden" name="month" value="<?php echo $currentMonth; ?>">
                    <input type="hidden" name="year" value="<?php echo $currentYear; ?>">
                    <div class="form-control">
                      <label class="label"><span class="label-text">Category</span></label>
                      <select name="category" class="select select-bordered select-sm" required>
                        <option disabled selected value="">Choose category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo htmlspecialchars($category['name']); ?>"><?php echo htmlspecialchars(ucwords(strtolower($category['name']))); ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="form-control mt-4">
                      <label class="label"><span class="label-text">Budget Amount</span></label>
                      <input type="number" name="amount" placeholder="0.00" step="0.01" min="0" class="input input-bordered input-sm" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm mt-4 w-full">
                      Set Budget
                    </button>
                  </form>
                </div>
              </div>
            </div>
            <!-- Main Content Area -->
            <div class="lg:col-span-3">
              <!-- Tabs Navigation -->
              <div role="tablist" class="tabs tabs-bordered mb-8">
                <input type="radio" name="main_tabs" role="tab" aria-label="Transaction History" checked="" id="i1lt6r" class="tab i1lt6r spark-custom-i1lt6r">
                <div role="tabpanel" class="tab-content">
                  <!-- Transaction History Content -->
                  <div class="card bg-base-100 shadow-soft">
                    <div id="i4nv4i" class="card-body i4nv4i spark-custom-i4nv4i">
                      
                    <!-- Month Navigation -->
                      <div class="flex items-center justify-center gap-4 mb-6">
                        <?php $anchor = '#main_content_layout'; ?>
                          <a href="<?php echo $prev_month_link . $anchor; ?>" class="btn btn-ghost">
                              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                          </a>
                          <div class="relative">
                              <button id="month-picker-button" class="text-xl font-bold text-center cursor-pointer hover:text-primary transition-colors">
                                  <?php echo $display_month_year; ?>
                              </button>
                          </div>
                          <a href="<?php echo $next_month_link . $anchor; ?>" class="btn btn-ghost">
                              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                          </a>
                      </div>

                      <!-- Month Picker Modal -->
                        <div id="month-picker-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                            <div class="bg-base-100 p-6 rounded-lg shadow-xl w-full max-w-xs">
                                <div class="flex items-center justify-between mb-4">
                                    <button id="prev-year" class="btn btn-ghost btn-sm">&lt;</button>
                                    <h4 id="picker-year" class="font-bold text-lg"><?php echo $currentYear; ?></h4>
                                    <button id="next-year" class="btn btn-ghost btn-sm">&gt;</button>
                                </div>
                                <div id="month-grid" class="grid grid-cols-3 gap-2">
                                    <?php
                                    for ($m = 1; $m <= 12; $m++) {
                                        $month_name = date('M', mktime(0, 0, 0, $m, 10));
                                        $is_current = ($m == $currentMonth && $currentYear == date('Y')) ? 'btn-primary' : 'btn-ghost';
                                        echo sprintf(
                                            '<button data-month="%d" class="month-button btn %s btn-sm">%s</button>',
                                            $m,
                                            $is_current,
                                            $month_name
                                        );
                                    }
                                    ?>
                                </div>
                                <button id="close-picker" class="btn btn-sm btn-circle btn-ghost absolute top-2 right-2">✕</button>
                            </div>
                        </div>

                      <!-- Search and Filter Controls -->
                      <form action="money.php" method="GET" class="flex flex-col md:flex-row gap-4 mb-6">
                        <input type="hidden" name="month" value="<?php echo $currentMonth; ?>">
                        <input type="hidden" name="year" value="<?php echo $currentYear; ?>">
                        <input type="hidden" name="balance_view" value="<?php echo $balance_view; ?>">

                        <div class="join flex-1">
                            <input type="text" name="search" placeholder="Search transactions..." value="<?php echo htmlspecialchars($search_term); ?>" class="input input-bordered join-item flex-1">
                        </div>
                        <div class="flex gap-2">
                            <select name="category" class="select select-bordered select-sm">
                                <option value="all">All Categories</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo htmlspecialchars($category['name']); ?>" <?php echo ($filter_category == $category['name']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars(ucwords(strtolower($category['name']))); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                        </div>
                      </form>
                      <!-- Transaction List -->
                      <div class="space-y-2">
                        <?php if (empty($transactions)): ?>
                          <div class="text-center text-base-content/60 py-8">
                            No transactions yet. Add one to get started!
                          </div>
                        <?php else: ?>
                          <?php
                            // Group transactions by date
                            $grouped_transactions = [];
                            foreach ($transactions as $transaction) {
                                $date = $transaction['transaction_date'];
                                if (!isset($grouped_transactions[$date])) {
                                    $grouped_transactions[$date] = [
                                        'transactions' => [],
                                        'total_income' => 0,
                                        'total_expense' => 0,
                                    ];
                                }
                                $grouped_transactions[$date]['transactions'][] = $transaction;
                                if ($transaction['transaction_type'] == 'income') {
                                    $grouped_transactions[$date]['total_income'] += $transaction['amount'];
                                } else {
                                    $grouped_transactions[$date]['total_expense'] += $transaction['amount'];
                                }
                            }
                          ?>
                          <?php foreach ($grouped_transactions as $date => $data): ?>
                            <div class="collapsible-group">
                              <!-- Date Summary Row -->
                              <div class="date-group-header flex items-center justify-between p-4 bg-base-200 rounded-lg cursor-pointer hover:bg-base-300 transition-colors">
                                <div class="flex items-center gap-3">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="toggle-icon h-5 w-5 transition-transform transform" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                                  <span class="font-bold text-lg"><?php echo date('D, j M ', strtotime($date)); ?></span>
                                </div>
                                <div class="flex items-center gap-4 text-sm">
                                  <?php if ($data['total_income'] > 0): ?>
                                    <span class="text-success font-semibold">Income: RM<?php echo number_format($data['total_income'], 2); ?></span>
                                  <?php endif; ?>
                                  <?php if ($data['total_expense'] > 0): ?>
                                    <span class="text-error font-semibold">Expense: RM<?php echo number_format($data['total_expense'], 2); ?></span>
                                  <?php endif; ?>
                                </div>
                              </div>
                              <!-- Transactions Container -->
                              <div class="transactions-container hidden pl-6 pt-2 space-y-3">
                                <?php foreach ($data['transactions'] as $transaction): ?>
                                  <?php
                                    $icon_type = $transaction['transaction_type'] == 'income' ? 'Income' : $transaction['category_name'];
                                    $icon = get_category_icon($icon_type);
                                  ?>
                                  <a href="money.php?action=edit_form&id=<?php echo $transaction['transaction_id']; ?>" class="flex items-center justify-between p-3 bg-base-100 rounded-lg hover:bg-base-200 transition-colors">
                                    <div class="flex items-center gap-4">
                                      <div class="w-10 h-10 rounded-full <?php echo $transaction['transaction_type'] == 'income' ? 'bg-success/20' : 'bg-error/20'; ?> flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="18" height="18" viewBox="0 0 24 24" class="iconify <?php echo $icon['color']; ?>">
                                          <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="<?php echo $icon['path']; ?>"/>
                                        </svg>
                                      </div>
                                      <div>
                                        <div class="font-semibold text-base">
                                          <?php echo htmlspecialchars($transaction['description']); ?>
                                        </div>
                                        <div class="text-sm text-base-content/60">
                                          <?php echo htmlspecialchars($transaction['category_name']); ?> &middot; <?php if ($transaction['transaction_date'] == date('Y-m-d')) { echo date('H:i:s', strtotime($transaction['created_at'])); } else { echo "unknown"; } ?>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="text-right">
                                      <div class="font-bold <?php echo $transaction['transaction_type'] == 'income' ? 'text-success' : 'text-error'; ?>">
                                        <?php echo $transaction['transaction_type'] == 'income' ? '+' : '-'; ?>RM<?php echo number_format($transaction['amount'], 2); ?>
                                      </div>
                                      <div class="badge <?php echo $transaction['transaction_type'] == 'income' ? 'badge-success' : 'badge-outline'; ?> badge-sm">
                                        <?php echo ucfirst($transaction['transaction_type']); ?>
                                      </div>
                                    </div>
                                  </a>
                                <?php endforeach; ?>
                              </div>
                            </div>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </div>
                      <!-- View More Button
                      <div class="text-center mt-8">
                        <button id="ir0ep1" class="btn btn-outline ir0ep1 spark-custom-ir0ep1">
                          Load More Transactions
                        </button>
                      </div> -->
                    </div>
                  </div>
                </div>
                <input type="radio" name="main_tabs" role="tab" aria-label="Budget Overview" id="imrotd" class="tab imrotd spark-custom-imrotd imrotd">
                <div role="tabpanel" class="tab-content" style="opacity: 1;">
                  <!-- Budget Overview Content -->
                  <div class="card bg-base-100 shadow-soft">
                    <div class="card-body">
                      <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold">Budget Progress</h3>
                        <!-- <button class="btn btn-primary btn-sm gap-2">
                          <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="16" height="16" viewBox="0 0 24 24" data-icon="heroicons:chart-bar" data-width="16" class="iconify iconify--heroicons"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875zm6.75-4.5c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125zm6.75-4.5c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125z"></path></svg>
                          View Trends
                        </button> -->
                      </div>
                      <!-- Budget Progress Cards -->
                      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php if (empty($budgets)): ?>
                          <div class="md:col-span-2 text-center text-base-content/60 py-8">No budgets to display.</div>
                        <?php else: ?>
                          <?php foreach ($budgets as $budget): ?>
                            <?php
                              $icon = get_category_icon($budget['category_name']);
                              $spent = $budget['spent'] ?? 0;
                              $amount = $budget['amount'];
                              $percentage = ($amount > 0) ? ($spent / $amount) * 100 : 0;
                              $remaining = $amount - $spent;
                            ?>
                            <div class="card bg-base-200">
                              <div class="card-body">
                                <div class="flex items-center justify-between mb-4">
                                  <div class="flex items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="24" height="24" viewBox="0 0 24 24" class="iconify <?php echo $icon['color']; ?>"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="<?php echo $icon['path']; ?>"></path></svg>
                                    <span class="font-semibold"><?php echo htmlspecialchars($budget['category_name']); ?></span>
                                  </div>
                                  <span class="text-sm text-base-content/60">RM<?php echo number_format($spent, 2); ?> / RM<?php echo number_format($amount, 2); ?></span>
                                </div>
                                <div class="w-full bg-base-300 rounded-full h-3 mb-2">
                                  <div class="<?php echo $icon['color']; ?> h-3 rounded-full" style="width: <?php echo $percentage; ?>%"></div>
                                </div>
                                <div class="flex justify-between text-sm">
                                  <span class="text-base-content/60"><?php echo round($percentage); ?>% used</span>
                                  <span class="font-medium <?php echo $icon['color']; ?>">RM<?php echo number_format($remaining, 2); ?> remaining</span>
                                </div>
                              </div>
                            </div>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
</main>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dateGroupHeaders = document.querySelectorAll('.date-group-header');
    dateGroupHeaders.forEach(header => {
        header.addEventListener('click', () => {
            const container = header.nextElementSibling;
            const icon = header.querySelector('.toggle-icon');

            if (container.classList.contains('hidden')) {
                container.classList.remove('hidden');
                icon.classList.add('rotate-90');
            } else {
                container.classList.add('hidden');
                icon.classList.remove('rotate-90');
            }
        });
    });

    // Month Picker Logic
    const monthPickerButton = document.getElementById('month-picker-button');
    const monthPickerModal = document.getElementById('month-picker-modal');
    const closePickerButton = document.getElementById('close-picker');
    const prevYearButton = document.getElementById('prev-year');
    const nextYearButton = document.getElementById('next-year');
    const pickerYear = document.getElementById('picker-year');
    const monthGrid = document.getElementById('month-grid');

    let currentPickerYear = <?php echo $currentYear; ?>;

    monthPickerButton.addEventListener('click', () => {
        monthPickerModal.classList.remove('hidden');
    });

    closePickerButton.addEventListener('click', () => {
        monthPickerModal.classList.add('hidden');
    });

    prevYearButton.addEventListener('click', () => {
        currentPickerYear--;
        pickerYear.textContent = currentPickerYear;
    });

    nextYearButton.addEventListener('click', () => {
        currentPickerYear++;
        pickerYear.textContent = currentPickerYear;
    });

    monthGrid.addEventListener('click', (e) => {
        if (e.target.classList.contains('month-button')) {
            const selectedMonth = e.target.dataset.month;
            window.location.href = `money.php?month=${selectedMonth}&year=${currentPickerYear}`;
        }
    });
});
</script>