<?php
// This file is loaded via MoneyController::showAddForm()
// Variables like $username, $userInitial are available from the controller

include __DIR__ . '/templates/header.php';
?>

<main class="flex-grow">
    <section class="w-full max-w-screen-xl mx-auto px-6 md:px-8 py-10">
        <!-- Page Header -->
        <section id="PageTitleSection" class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-bold font-heading mb-4 text-base-content">
          Add New Transaction
        </h1>
        <p class="text-lg text-base-content/70 max-w-2xl mx-auto">
          Record all your financial movements, whether it's income or expense,
          to keep track of your cash flow.
        </p>
      </section>

        <!-- Success/Error Messages -->
        <?php if (isset($_SESSION['success_message'])): ?>
        <div id="toast-success"
            class="fixed top-20 right-5 z-50 w-80 
                    alert alert-success shadow-lg rounded-lg 
                    flex items-center gap-2 transition-opacity duration-500">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="stroke-current flex-shrink-0 h-6 w-6"
                fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>
            <?php echo htmlspecialchars($_SESSION['success_message']); unset($_SESSION['success_message']); ?>
            </span>
        </div>

        <script>
            // Auto-hide after 3.5 seconds
            setTimeout(() => {
            const toast = document.getElementById('toast-success');
            if (toast) {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 500); // remove after fade-out
            }
            }, 3500);
        </script>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-error shadow-lg mb-4">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span><?php echo htmlspecialchars($_SESSION['error_message']); unset($_SESSION['error_message']); ?></span>
                </div>
            </div>
        <?php endif; ?>

        <!-- Add Transaction Form -->
        <section id="AddTransactionForm" class="AddTransactionForm spark-custom-AddTransactionForm">
            <div class="card max-w-3xl mx-auto bg-base-100 shadow-soft p-8 md:p-12 rounded-box">
            <form class="space-y-8" method="POST" action="money.php?action=add">
                <div class="form-control">
                <label class="label"><span class="label-text text-base font-medium">Transaction Type</span></label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-2">
                    <div>
                    <input type="radio" name="type" id="income_radio" value="income" checked class="hidden"><label for="income_radio" class="flex items-center gap-3 p-4 border-2 border-base-300 rounded-lg cursor-pointer transition-all duration-300"><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" viewBox="0 0 20 20" data-icon="heroicons:arrow-up-circle-20-solid" class="iconify text-2xl"><path fill="currentColor" fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16a8 8 0 0 0 0 16m-.75-4.75a.75.75 0 0 0 1.5 0V8.66l1.95 2.1a.75.75 0 1 0 1.1-1.02l-3.25-3.5a.75.75 0 0 0-1.1 0L6.2 9.74a.75.75 0 1 0 1.1 1.02l1.95-2.1z" clip-rule="evenodd"></path></svg><span class="font-medium peer-checked:text-white">Income</span></label>
                    </div>
                    <div>
                    <input type="radio" name="type" id="expense_radio" value="expense" class="hidden"><label for="expense_radio" class="flex items-center gap-3 p-4 border-2 border-base-300 rounded-lg cursor-pointer transition-all duration-300"><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" viewBox="0 0 20 20" data-icon="heroicons:arrow-down-circle-20-solid" class="iconify text-2xl"><path fill="currentColor" fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16a8 8 0 0 0 0 16m.75-11.25a.75.75 0 0 0-1.5 0v4.59L7.3 9.24a.75.75 0 0 0-1.1 1.02l3.25 3.5a.75.75 0 0 0 1.1 0l3.25-3.5a.75.75 0 1 0-1.1-1.02l-1.95 2.1z" clip-rule="evenodd"></path></svg><span class="font-medium peer-checked:text-white">Expense</span></label>
                    </div>
                </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="form-control">
                    <label for="amount" class="label"><span class="label-text text-base font-medium">Amount</span></label><label class="input input-bordered flex items-center gap-2 mt-2"><span class="text-base-content/50 font-medium">RM</span><input type="number" name="amount" id="amount" placeholder="0.00" step="0.01" min=0 required="" class="grow"></label>
                </div>
                <div class="form-control">
                    <label for="date" class="label"><span class="label-text text-base font-medium i68i88 spark-custom-i68i88" id="i68i88">Date of Transaction</span></label>
                    <?php 
                        date_default_timezone_set('Asia/Kuala_Lumpur');
                        $today = date('Y-m-d');
                    ?>
                    <input type="date" name="date" id="date" required
                    class="input input-bordered w-full mt-2 date spark-custom-date"
                    value="<?= $today ?>" max="<?= $today ?>">
                </div>
                </div>
                <div class="form-control i5io46 spark-custom-i5io46" id="i5io46">
                <label for="category" class="label"><span class="label-text text-base font-medium">Category</span></label>
                <select name="category" id="category" required="" class="select select-bordered w-full mt-2">
                    <option disabled="" selected="" value="">
                        Select a category
                    </option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['name']) ?>"><?= htmlspecialchars(ucwords(strtolower($category['name']))) ?></option>
                    <?php endforeach; ?>
                    <option value="Other">Other</option>
                </select>
                </div>
                <div class="form-control mt-4" id="other-category-container" style="display: none;">
                    <label for="other_category" class="label"><span class="label-text text-base font-medium">Please specify your category</span></label>
                    <input type="text" name="other_category" id="other_category" class="input input-bordered w-full" />
                </div>
                <div class="form-control md:col-span-2">
                        <label class="label"><span class="label-text">Description (Optional)</span></label>
                        <textarea name="description" placeholder="e.g., Dinner with friends" class="textarea textarea-bordered w-full"></textarea>
                    </div>
                <div class="flex flex-col-reverse sm:flex-row gap-4 justify-end pt-4">
                <button type="button" class="btn btn-ghost" onclick="window.location.href='money.php'">
                    Cancel</button><button type="submit" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="20" height="20" viewBox="0 0 20 20" data-icon="heroicons:folder-plus-20-solid" data-width="20" class="iconify iconify--heroicons"><path fill="currentColor" fill-rule="evenodd" d="M3.75 3A1.75 1.75 0 0 0 2 4.75v10.5c0 .966.784 1.75 1.75 1.75h12.5A1.75 1.75 0 0 0 18 15.25v-8.5A1.75 1.75 0 0 0 16.25 5h-4.836a.25.25 0 0 1-.177-.073L9.823 3.513A1.75 1.75 0 0 0 8.586 3zM10 8a.75.75 0 0 1 .75.75v1.5h1.5a.75.75 0 0 1 0 1.5h-1.5v1.5a.75.75 0 0 1-1.5 0v-1.5h-1.5a.75.75 0 0 1 0-1.5h1.5v-1.5A.75.75 0 0 1 10 8" clip-rule="evenodd"></path></svg>
                    Save Transaction
                </button>
                </div>
            </form>
            </div>
        </section>

        <!-- Back to Money Tracker Button -->
        <div class="text-center mt-8">
            <button onclick="window.location.href = 'money.php';" class="btn btn-ghost gap-2 text-base-content/70 hover:text-base-content">
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="20" height="20" viewBox="0 0 24 24" class="iconify"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path></svg>
                Back to Money Tracker
            </button>
        </div>

    </section>
</main>

<style>
    .income-selected {
        background-color: #36d399; /* success color from daisyUI */
        border-color: #36d399;
        color: white;
    }
    .expense-selected {
        background-color: #f87272; /* error color from daisyUI */
        border-color: #f87272;
        color: white;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const incomeRadio = document.getElementById('income_radio');
        const expenseRadio = document.getElementById('expense_radio');
        const incomeLabel = document.querySelector('label[for="income_radio"]');
        const expenseLabel = document.querySelector('label[for="expense_radio"]');

        function updateStyles() {
            if (incomeRadio.checked) {
                incomeLabel.classList.add('income-selected');
                expenseLabel.classList.remove('expense-selected');
            } else {
                incomeLabel.classList.remove('income-selected');
                expenseLabel.classList.add('expense-selected');
            }
        }

        incomeRadio.addEventListener('change', updateStyles);
        expenseRadio.addEventListener('change', updateStyles);

        // Initial state
        updateStyles();

        const categorySelect = document.getElementById('category');
        const otherCategoryContainer = document.getElementById('other-category-container');
        const otherCategoryInput = document.getElementById('other_category');

        categorySelect.addEventListener('change', function() {
            if (this.value === 'Other') {
                otherCategoryContainer.style.display = 'block';
                otherCategoryInput.setAttribute('required', 'required');
            } else {
                otherCategoryContainer.style.display = 'none';
                otherCategoryInput.removeAttribute('required');
                otherCategoryInput.value = '';
            }
        });
    });
</script>

<?php
include __DIR__ . '/templates/footer.php';
?>