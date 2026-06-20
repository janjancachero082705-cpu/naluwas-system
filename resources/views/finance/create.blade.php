<h1>Add Finance Record</h1>

<form method="POST" action="/finance">
    @csrf

    <select name="type">
        <option value="offering">Offering</option>
        <option value="donation">Donation</option>
        <option value="expense">Expense</option>
    </select><br><br>

    <input type="number" name="amount" placeholder="Amount"><br><br>

    <input type="date" name="date"><br><br>

    <textarea name="description" placeholder="Description"></textarea><br><br>

    <button>Save</button>
</form>