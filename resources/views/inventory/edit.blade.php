@extends('layouts.app')

@section('header', 'Edit Transaction')

@section('content')

<style>
    /* ============================================
       PREMIUM EDIT FORM DESIGN FOR INVENTORY
    ============================================ */
    
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');
    
    .edit-hero {
        border-radius: 24px;
        padding: 2rem 2.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(0,0,0,0.3);
    }
    
    .edit-hero.income-hero {
        background: linear-gradient(135deg, #10B981, #059669);
        box-shadow: 0 8px 32px rgba(16, 185, 129, 0.3);
    }
    
    .edit-hero.expense-hero {
        background: linear-gradient(135deg, #EF4444, #DC2626);
        box-shadow: 0 8px 32px rgba(239, 68, 68, 0.3);
    }
    
    .edit-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 60%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
        animation: heroPulse 6s ease-in-out infinite;
    }
    
    .edit-hero::after {
        content: '';
        position: absolute;
        bottom: -40%;
        left: -10%;
        width: 40%;
        height: 180%;
        background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
        animation: heroPulse 8s ease-in-out infinite reverse;
    }
    
    @keyframes heroPulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.1); opacity: 1; }
    }
    
    .edit-hero .hero-content {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .edit-hero .hero-left {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }
    
    .edit-hero .hero-avatar {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: rgba(255,255,255,0.15);
        border: 3px solid rgba(255,255,255,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        font-weight: 800;
        flex-shrink: 0;
        backdrop-filter: blur(10px);
        box-shadow: 0 8px 32px rgba(0,0,0,0.15);
    }
    
    .edit-hero .hero-text h1 {
        font-size: 1.6rem;
        font-weight: 800;
        color: white;
        margin: 0;
        font-family: 'Inter', sans-serif;
        letter-spacing: -0.5px;
    }
    
    .edit-hero .hero-text .hero-sub {
        color: rgba(255,255,255,0.85);
        font-size: 0.85rem;
        margin: 4px 0 0 0;
    }
    
    .edit-hero .hero-text .hero-sub i {
        margin-right: 6px;
    }
    
    .edit-hero .hero-text .hero-sub .badge-type {
        display: inline-block;
        padding: 2px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        background: rgba(255,255,255,0.2);
        color: white;
        margin-left: 6px;
    }
    
    .edit-hero .hero-actions {
        display: flex;
        gap: 0.6rem;
        flex-wrap: wrap;
        position: relative;
        z-index: 1;
    }
    
    .btn-hero-edit {
        padding: 0.5rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.75rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        border: none;
        text-decoration: none;
    }
    
    .btn-hero-edit-white {
        background: white;
        color: #10B981;
    }
    
    .btn-hero-edit-white:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        color: #10B981;
        text-decoration: none;
    }
    
    .btn-hero-edit-ghost {
        background: rgba(255,255,255,0.15);
        color: white;
        border: 1px solid rgba(255,255,255,0.2);
    }
    
    .btn-hero-edit-ghost:hover {
        background: rgba(255,255,255,0.25);
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }
    
    .edit-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    
    .edit-card:hover {
        box-shadow: 0 24px 80px rgba(0,0,0,0.12);
    }
    
    .edit-card-header {
        padding: 1.2rem 1.8rem;
        border-bottom: 1px solid #e5e7eb;
        background: #f9fafb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.8rem;
    }
    
    .edit-card-header h5 {
        font-size: 1.1rem;
        font-weight: 700;
        margin: 0;
        color: #1a1a2e;
        font-family: 'Inter', sans-serif;
    }
    
    .edit-card-header h5 i {
        color: #4F46E5;
        margin-right: 10px;
    }
    
    .edit-card-header .transaction-id-badge {
        font-size: 0.7rem;
        color: #6b7280;
        background: #ffffff;
        padding: 4px 14px;
        border-radius: 20px;
        border: 1px solid #e5e7eb;
        font-weight: 600;
    }
    
    .edit-card-body {
        padding: 2rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6b7280;
        margin-bottom: 0.4rem;
        display: block;
        font-family: 'Inter', sans-serif;
    }
    
    .form-label .required {
        color: #EF4444;
        margin-left: 3px;
    }
    
    .form-label i {
        margin-right: 6px;
        opacity: 0.6;
    }
    
    .form-control {
        width: 100% !important;
        padding: 12px 16px !important;
        border: 2px solid #d1d5db !important;
        border-radius: 12px !important;
        font-size: 15px !important;
        color: #1a1a2e !important;
        background: #ffffff !important;
        transition: all 0.25s ease !important;
        outline: none !important;
        box-sizing: border-box !important;
        font-family: 'Inter', sans-serif !important;
        cursor: text !important;
        pointer-events: auto !important;
        -webkit-appearance: none !important;
        appearance: none !important;
        user-select: text !important;
        -webkit-user-select: text !important;
    }
    
    .form-control:hover {
        border-color: #4F46E5 !important;
        background: #fafaff !important;
    }
    
    .form-control:focus {
        border-color: #4F46E5 !important;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12) !important;
        background: #ffffff !important;
        outline: none !important;
    }
    
    .form-control.is-invalid {
        border-color: #EF4444 !important;
    }
    
    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.08) !important;
    }
    
    .form-control::placeholder {
        color: #9ca3af;
        opacity: 0.7;
    }
    
    .form-control[type="date"] {
        cursor: pointer !important;
        min-height: 48px !important;
    }
    
    .form-control[type="number"] {
        -moz-appearance: textfield !important;
    }
    
    .form-control[type="number"]::-webkit-outer-spin-button,
    .form-control[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none !important;
        margin: 0 !important;
    }
    
    select.form-control {
        cursor: pointer !important;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b7280' d='M6 8L1 3h10z'/%3E%3C/svg%3E") !important;
        background-repeat: no-repeat !important;
        background-position: right 16px center !important;
        padding-right: 40px !important;
    }
    
    textarea.form-control {
        resize: vertical !important;
        min-height: 80px !important;
        line-height: 1.6 !important;
    }
    
    .invalid-feedback {
        color: #EF4444;
        font-size: 0.75rem;
        margin-top: 0.3rem;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    .invalid-feedback i {
        font-size: 0.7rem;
    }
    
    .amount-input-wrapper {
        display: flex !important;
        align-items: center !important;
        border: 2px solid #d1d5db !important;
        border-radius: 12px !important;
        background: #ffffff !important;
        transition: all 0.25s ease !important;
        overflow: hidden !important;
    }
    
    .amount-input-wrapper:hover {
        border-color: #4F46E5 !important;
        background: #fafaff !important;
    }
    
    .amount-input-wrapper:focus-within {
        border-color: #4F46E5 !important;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12) !important;
    }
    
    .amount-input-wrapper .currency-symbol {
        padding: 12px 16px !important;
        background: #f9fafb !important;
        color: #6b7280 !important;
        font-weight: 700 !important;
        font-size: 15px !important;
        border-right: 2px solid #d1d5db !important;
        flex-shrink: 0 !important;
        font-family: 'Inter', sans-serif !important;
        cursor: default !important;
    }
    
    .amount-input-wrapper input {
        width: 100% !important;
        padding: 12px 16px !important;
        border: none !important;
        font-size: 15px !important;
        color: #1a1a2e !important;
        background: transparent !important;
        outline: none !important;
        box-sizing: border-box !important;
        font-family: 'Inter', sans-serif !important;
        cursor: text !important;
        pointer-events: auto !important;
    }
    
    .amount-input-wrapper input:hover {
        background: transparent !important;
    }
    
    .amount-input-wrapper input:focus {
        background: transparent !important;
    }
    
    .amount-input-wrapper input::-webkit-outer-spin-button,
    .amount-input-wrapper input::-webkit-inner-spin-button {
        -webkit-appearance: none !important;
        margin: 0 !important;
    }
    
    .amount-input-wrapper input[type="number"] {
        -moz-appearance: textfield !important;
    }
    
    .type-select-wrapper {
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
    }
    
    .type-select-wrapper select {
        flex: 1 !important;
        padding: 12px 16px !important;
        border: 2px solid #d1d5db !important;
        border-radius: 12px !important;
        font-size: 15px !important;
        color: #1a1a2e !important;
        background: #ffffff !important;
        transition: all 0.25s ease !important;
        outline: none !important;
        cursor: pointer !important;
        font-family: 'Inter', sans-serif !important;
        min-height: 48px !important;
        -webkit-appearance: none !important;
        appearance: none !important;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b7280' d='M6 8L1 3h10z'/%3E%3C/svg%3E") !important;
        background-repeat: no-repeat !important;
        background-position: right 16px center !important;
        padding-right: 40px !important;
        pointer-events: auto !important;
    }
    
    .type-select-wrapper select:hover {
        border-color: #4F46E5 !important;
        background-color: #fafaff !important;
    }
    
    .type-select-wrapper select:focus {
        border-color: #4F46E5 !important;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12) !important;
    }
    
    .type-badge-display {
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        padding: 8px 18px !important;
        border-radius: 20px !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        white-space: nowrap !important;
        font-family: 'Inter', sans-serif !important;
        flex-shrink: 0 !important;
    }
    
    .type-badge-display.income {
        background: rgba(16, 185, 129, 0.12) !important;
        color: #10B981 !important;
    }
    
    .type-badge-display.expense {
        background: rgba(239, 68, 68, 0.12) !important;
        color: #EF4444 !important;
    }
    
    .info-section {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.04), rgba(139, 92, 246, 0.04));
        border-radius: 16px;
        padding: 1.5rem;
        border: 2px solid rgba(79, 70, 229, 0.08);
        margin-top: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .info-section:hover {
        border-color: rgba(79, 70, 229, 0.15);
        box-shadow: 0 4px 20px rgba(79, 70, 229, 0.05);
    }
    
    .info-section .info-title {
        font-size: 0.8rem;
        font-weight: 700;
        color: #4F46E5;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
        font-family: 'Inter', sans-serif;
    }
    
    .info-section .info-title i {
        font-size: 1rem;
    }
    
    .btn-back-edit {
        padding: 0.5rem 1.2rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.75rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        border: 2px solid #e5e7eb;
        background: transparent;
        color: #6b7280;
        text-decoration: none;
        font-family: 'Inter', sans-serif;
    }
    
    .btn-back-edit:hover {
        background: #f9fafb;
        color: #1a1a2e;
        text-decoration: none;
        transform: translateX(-3px);
        border-color: #1a1a2e;
    }
    
    .btn-update-edit {
        padding: 0.7rem 2.5rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.8rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        border: none;
        background: linear-gradient(135deg, #10B981, #059669);
        color: white;
        text-decoration: none;
        box-shadow: 0 4px 16px rgba(16, 185, 129, 0.25);
        font-family: 'Inter', sans-serif;
        letter-spacing: 0.3px;
    }
    
    .btn-update-edit:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 32px rgba(16, 185, 129, 0.35);
        color: white;
    }
    
    .btn-update-edit:active {
        transform: scale(0.97);
    }
    
    .btn-danger-edit {
        padding: 0.7rem 1.5rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.8rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        border: none;
        background: linear-gradient(135deg, #EF4444, #DC2626);
        color: white;
        text-decoration: none;
        box-shadow: 0 4px 16px rgba(239, 68, 68, 0.25);
        font-family: 'Inter', sans-serif;
        letter-spacing: 0.3px;
    }
    
    .btn-danger-edit:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 32px rgba(239, 68, 68, 0.35);
        color: white;
    }
    
    .btn-danger-edit:active {
        transform: scale(0.97);
    }
    
    .form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e5e7eb;
    }
    
    /* Category dropdown styling */
    .category-select-wrapper {
        position: relative;
    }
    
    .category-select-wrapper select.form-control {
        cursor: pointer !important;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b7280' d='M6 8L1 3h10z'/%3E%3C/svg%3E") !important;
        background-repeat: no-repeat !important;
        background-position: right 16px center !important;
        padding-right: 40px !important;
        min-height: 48px !important;
    }
    
    .category-select-wrapper select.form-control option {
        padding: 8px 12px;
        font-family: 'Inter', sans-serif;
    }
    
    @media (max-width: 768px) {
        .edit-hero {
            padding: 1.5rem;
        }
        
        .edit-hero .hero-content {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .edit-hero .hero-actions {
            width: 100%;
        }
        
        .edit-hero .hero-left {
            width: 100%;
        }
        
        .edit-hero .hero-avatar {
            width: 55px;
            height: 55px;
            font-size: 1.4rem;
        }
        
        .edit-hero .hero-text h1 {
            font-size: 1.3rem;
        }
        
        .edit-card-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .edit-card-body {
            padding: 1.2rem;
        }
        
        .type-select-wrapper {
            flex-direction: column !important;
            align-items: stretch !important;
        }
        
        .type-select-wrapper select {
            flex: none !important;
        }
        
        .type-badge-display {
            align-self: flex-start !important;
        }
        
        .form-actions {
            flex-direction: column-reverse;
            align-items: stretch;
        }
        
        .btn-update-edit, .btn-danger-edit {
            justify-content: center;
            padding: 0.7rem 1.5rem;
        }
        
        .btn-back-edit {
            justify-content: center;
        }
    }
    
    @media (max-width: 480px) {
        .edit-hero .hero-avatar {
            width: 45px;
            height: 45px;
            font-size: 1.2rem;
        }
        
        .edit-hero .hero-text h1 {
            font-size: 1.1rem;
        }
        
        .edit-card-body {
            padding: 1rem;
        }
    }
</style>

<div class="container-fluid px-0">
    <div class="edit-hero {{ $transaction->type == 'income' ? 'income-hero' : 'expense-hero' }}">
        <div class="hero-content">
            <div class="hero-left">
                <div class="hero-avatar">
                    <i class="fas {{ $transaction->type == 'income' ? 'fa-arrow-down' : 'fa-arrow-up' }}"></i>
                </div>
                <div class="hero-text">
                    <h1>Edit Transaction</h1>
                    <p class="hero-sub">
                        <i class="fas fa-tag"></i>
                        {{ $transaction->description ?? 'Untitled' }}
                        <span style="opacity: 0.5; margin: 0 6px;">·</span>
                        <i class="fas fa-{{ $transaction->type == 'income' ? 'arrow-down' : 'arrow-up' }}"></i>
                        {{ ucfirst($transaction->type) }}
                        <span class="badge-type">₱{{ number_format($transaction->amount ?? 0, 2) }}</span>
                    </p>
                </div>
            </div>
            <div class="hero-actions">
                <a href="{{ route('inventory.index') }}" class="btn-hero-edit btn-hero-edit-white">
                    <i class="fas fa-arrow-left"></i> Back to Inventory
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="edit-card">
                <div class="edit-card-header">
                    <h5>
                        <i class="fas fa-edit"></i> Edit Transaction Details
                    </h5>
                    <span class="transaction-id-badge">
                        <i class="fas fa-hashtag"></i> {{ str_pad($transaction->id ?? 0, 4, '0', STR_PAD_LEFT) }}
                        <span style="opacity:0.3; margin:0 6px;">·</span>
                        <i class="fas fa-clock"></i> {{ $transaction->updated_at ? \Carbon\Carbon::parse($transaction->updated_at)->diffForHumans() : 'Never' }}
                    </span>
                </div>
                <div class="edit-card-body">
                    <form action="{{ route('inventory.update', $transaction->id) }}" method="POST" id="editForm">
                        @csrf
                        @method('PUT')
                        
                        {{-- Hidden fields to track old values for balance recalculation --}}
                        <input type="hidden" name="old_type" value="{{ $transaction->type }}">
                        <input type="hidden" name="old_amount" value="{{ $transaction->amount }}">
                        
                        <div class="row g-4">
                            <div class="col-12">
                                <h6 class="fw-bold text-primary mb-3" style="font-family: 'Inter', sans-serif;">
                                    <i class="fas fa-info-circle me-2"></i> Transaction Details
                                </h6>
                            </div>
                            
                            <!-- DESCRIPTION -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-tag"></i> Description <span class="required">*</span>
                                    </label>
                                    <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" 
                                           value="{{ old('description', $transaction->description) }}" 
                                           placeholder="Enter transaction description" required>
                                    @error('description')
                                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- CATEGORY - DROPDOWN WITH SPECIFIED OPTIONS -->
                            <div class="col-md-6">
                                <div class="form-group category-select-wrapper">
                                    <label class="form-label">
                                        <i class="fas fa-folder"></i> Category <span class="required">*</span>
                                    </label>
                                    <select name="category" class="form-control @error('category') is-invalid @enderror" required>
                                        @php
                                            $incomeCategories = [
                                                'Sunday Offering', 'Tithes', 'Special Donation', 
                                                'Building Fund', 'Missions', 'Benevolence', 
                                                'Thanksgiving', 'Rental Income', 'Other Income'
                                            ];
                                            $expenseCategories = [
                                                'Church Help', 'Outreach', 'Donation to Others',
                                                'Maintenance', 'Utilities', 'Staff Salary',
                                                'Equipment', 'Events', 'Other Expense'
                                            ];
                                            $allCategories = array_merge($incomeCategories, $expenseCategories);
                                            sort($allCategories);
                                        @endphp
                                        <option value="">-- Select Category --</option>
                                        @foreach($allCategories as $cat)
                                            <option value="{{ $cat }}" 
                                                {{ old('category', $transaction->category) == $cat ? 'selected' : '' }}>
                                                {{ $cat }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- AMOUNT -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-money-bill-wave"></i> Amount (₱) <span class="required">*</span>
                                    </label>
                                    <div class="amount-input-wrapper">
                                        <span class="currency-symbol">₱</span>
                                        <input type="number" name="amount" step="0.01" 
                                               class="@error('amount') is-invalid @enderror" 
                                               value="{{ old('amount', $transaction->amount) }}" 
                                               placeholder="0.00" required
                                               style="width: 100%; padding: 12px 16px; border: none; font-size: 15px; color: #1a1a2e; background: transparent; outline: none; box-sizing: border-box; font-family: 'Inter', sans-serif; cursor: text !important;">
                                    </div>
                                    @error('amount')
                                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- DATE -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-calendar"></i> Date <span class="required">*</span>
                                    </label>
                                    <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" 
                                           value="{{ old('date', $transaction->date ? \Carbon\Carbon::parse($transaction->date)->format('Y-m-d') : '') }}" required>
                                    @error('date')
                                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- TYPE -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-info-circle"></i> Type <span class="required">*</span>
                                    </label>
                                    <div class="type-select-wrapper">
                                        <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                                            <option value="income" {{ old('type', $transaction->type) == 'income' ? 'selected' : '' }}>Income</option>
                                            <option value="expense" {{ old('type', $transaction->type) == 'expense' ? 'selected' : '' }}>Expense</option>
                                        </select>
                                        <span id="typeDisplay" class="type-badge-display {{ $transaction->type }}">
                                            <i class="fas {{ $transaction->type == 'income' ? 'fa-arrow-down' : 'fa-arrow-up' }}"></i>
                                            {{ ucfirst($transaction->type) }}
                                        </span>
                                    </div>
                                    @error('type')
                                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- DONOR NAME (for Income) -->
                            <div id="donorGroup" class="col-md-6" style="{{ old('type', $transaction->type) == 'income' ? 'display:block;' : 'display:none;' }}">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-user"></i> Donor Name
                                    </label>
                                    <input type="text" name="donor_name" id="donor_name" class="form-control @error('donor_name') is-invalid @enderror" 
                                           value="{{ old('donor_name', $transaction->donor_name) }}" 
                                           placeholder="Enter donor name">
                                    @error('donor_name')
                                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- RECIPIENT (for Expense) -->
                            <div id="recipientGroup" class="col-md-6" style="{{ old('type', $transaction->type) == 'expense' ? 'display:block;' : 'display:none;' }}">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-user"></i> Recipient / Beneficiary
                                    </label>
                                    <input type="text" name="recipient" id="recipient" class="form-control @error('recipient') is-invalid @enderror" 
                                           value="{{ old('recipient', $transaction->recipient) }}" 
                                           placeholder="Enter recipient name">
                                    @error('recipient')
                                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- REMARKS -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-pen"></i> Remarks / Notes
                                    </label>
                                    <textarea name="remarks" class="form-control @error('remarks') is-invalid @enderror" 
                                              rows="3" placeholder="Enter additional notes...">{{ old('remarks', $transaction->remarks) }}</textarea>
                                    @error('remarks')
                                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Balance Info -->
                            <div class="col-12">
                                <div class="info-section">
                                    <div class="info-title">
                                        <i class="fas fa-wallet"></i> Financial Impact
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="small text-muted">Current Transaction</div>
                                            <div class="fw-bold {{ $transaction->type == 'income' ? 'text-success' : 'text-danger' }}" style="font-size: 1.2rem;">
                                                {{ $transaction->type == 'income' ? '+' : '-' }} ₱{{ number_format($transaction->amount ?? 0, 2) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="small text-muted">Balance Without This Transaction</div>
                                            <div class="fw-bold text-primary" style="font-size: 1.2rem;">
                                                ₱{{ number_format($balance ?? 0, 2) }}
                                            </div>
                                            <div class="small text-muted" style="font-size: 0.65rem;">
                                                (Balance before editing this transaction)
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="small text-muted">Total Transactions</div>
                                            <div class="fw-bold" style="font-size: 1.2rem;">
                                                {{ \App\Models\MoneyTransaction::where('church_id', $transaction->church_id)->count() }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3 pt-2 border-top">
                                        <div class="col-12">
                                            <div class="small text-muted mb-1">💡 Note: Changing the amount or type will automatically recalculate the church balance.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <a href="{{ route('inventory.index') }}" class="btn-back-edit">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <div class="d-flex gap-2 flex-wrap">
                                <button type="button" class="btn-danger-edit" onclick="confirmDelete({{ $transaction->id }})">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                                <button type="submit" class="btn-update-edit">
                                    <i class="fas fa-save"></i> Update Transaction
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Type change handler
        const typeSelect = document.getElementById('type');
        const typeDisplay = document.getElementById('typeDisplay');
        const donorGroup = document.getElementById('donorGroup');
        const recipientGroup = document.getElementById('recipientGroup');
        const donorName = document.getElementById('donor_name');
        const recipient = document.getElementById('recipient');
        
        if (typeSelect) {
            typeSelect.addEventListener('change', function() {
                if (this.value === 'income') {
                    typeDisplay.className = 'type-badge-display income';
                    typeDisplay.innerHTML = '<i class="fas fa-arrow-down"></i> Income';
                    donorGroup.style.display = 'block';
                    recipientGroup.style.display = 'none';
                    if (recipient) recipient.value = '';
                } else {
                    typeDisplay.className = 'type-badge-display expense';
                    typeDisplay.innerHTML = '<i class="fas fa-arrow-up"></i> Expense';
                    donorGroup.style.display = 'none';
                    recipientGroup.style.display = 'block';
                    if (donorName) donorName.value = '';
                }
            });
        }
        
        // Delete confirmation - FIXED to use correct route
        window.confirmDelete = function(id) {
            Swal.fire({
                title: 'Delete Transaction?',
                text: 'This action cannot be undone. All financial records will be updated.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Deleting...',
                        text: 'Please wait...',
                        allowOutsideClick: false,
                        didOpen: () => { Swal.showLoading(); }
                    });
                    
                    // Use the correct route for deletion
                    fetch(`/inventory/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.close();
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: data.message || 'Transaction deleted successfully.',
                                timer: 2000,
                                showConfirmButton: false,
                                toast: true,
                                position: 'top-end'
                            });
                            setTimeout(() => {
                                window.location.href = '{{ route("inventory.index") }}';
                            }, 500);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message || 'Failed to delete transaction.',
                                confirmButtonColor: '#EF4444'
                            });
                        }
                    })
                    .catch(error => {
                        Swal.close();
                        console.error('Delete error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong. Please try again.',
                            confirmButtonColor: '#EF4444'
                        });
                    });
                }
            });
        };
        
        // Form changed warning
        let formChanged = false;
        const form = document.getElementById('editForm');
        if (form) {
            const inputs = form.querySelectorAll('input, select, textarea');
            
            inputs.forEach(input => {
                input.addEventListener('change', function() {
                    formChanged = true;
                });
                if (input.type === 'text' || input.type === 'number' || input.tagName === 'TEXTAREA') {
                    input.addEventListener('input', function() {
                        formChanged = true;
                    });
                }
            });
            
            window.addEventListener('beforeunload', function(e) {
                if (formChanged) {
                    e.preventDefault();
                    e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
                    return e.returnValue;
                }
            });
            
            form.addEventListener('submit', function() {
                formChanged = false;
            });
        }
        
        // Invalid fields focus
        const invalidFields = document.querySelectorAll('.is-invalid');
        if (invalidFields.length > 0) {
            invalidFields[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
            invalidFields[0].focus();
        }
        
        // Card animation
        const card = document.querySelector('.edit-card');
        if (card) {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        }
    });
</script>

@endsection