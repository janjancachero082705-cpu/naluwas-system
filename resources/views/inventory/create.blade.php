@extends('layouts.app')

@section('header', 'Add Inventory Item')

@section('content')
<style>
    .form-container {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .form-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        overflow: hidden;
    }
    
    .card-header-custom {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-tertiary);
    }
    
    .card-header-custom h4 {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-primary);
    }
    
    .card-body-custom {
        padding: 1.5rem;
    }
    
    /* Two Column Grid Layout */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
    
    .form-group {
        margin-bottom: 0;
    }
    
    .form-group-full {
        grid-column: span 2;
    }
    
    .form-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        color: var(--text-muted);
        margin-bottom: 0.35rem;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .form-label i {
        font-size: 0.7rem;
        width: 14px;
    }
    
    .required {
        color: #ef4444;
        font-size: 0.7rem;
    }
    
    .form-control, .form-select, textarea {
        width: 100%;
        padding: 0.6rem 0.8rem;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        background: var(--input-bg);
        color: var(--text-primary);
        font-size: 0.8rem;
        transition: all 0.2s ease;
    }
    
    .form-control:focus, .form-select:focus, textarea:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    textarea {
        resize: vertical;
        min-height: 70px;
    }
    
    /* Quantity & Price Row */
    .quantity-price-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    
    /* Helper Text */
    .helper-text {
        font-size: 0.65rem;
        color: var(--text-muted);
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    .helper-text i {
        font-size: 0.6rem;
    }
    
    /* Status Buttons - Better than Select */
    .status-options {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    
    .status-option {
        flex: 1;
        padding: 0.6rem 1rem;
        border-radius: 10px;
        cursor: pointer;
        text-align: center;
        font-size: 0.75rem;
        font-weight: 600;
        transition: all 0.2s ease;
        background: var(--bg-tertiary);
        border: 2px solid var(--border-color);
        color: var(--text-secondary);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }
    
    .status-option i {
        font-size: 0.75rem;
    }
    
    .status-option.active {
        border-color: #10b981;
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }
    
    .status-option[data-status="damaged"].active {
        border-color: #f59e0b;
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }
    
    .status-option[data-status="lost"].active {
        border-color: #ef4444;
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }
    
    /* Action Buttons */
    .button-group {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
        padding-top: 1rem;
        border-top: 1px solid var(--border-color);
    }
    
    .btn-submit {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        padding: 0.65rem 1.5rem;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
    }
    
    .btn-cancel {
        background: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
        padding: 0.65rem 1.5rem;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        flex: 1;
    }
    
    .btn-cancel:hover {
        background: var(--hover-bg);
        border-color: var(--border-color);
        color: var(--text-primary);
    }
    
    /* Divider */
    .divider {
        margin: 1rem 0;
        height: 1px;
        background: var(--border-color);
    }
    
    /* Responsive */
    @media (max-width: 640px) {
        .form-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        .form-group-full {
            grid-column: span 1;
        }
        .quantity-price-row {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        .status-options {
            flex-direction: column;
        }
        .button-group {
            flex-direction: column;
        }
        .card-body-custom {
            padding: 1rem;
        }
    }
</style>

<div class="form-container">
    <div class="form-card">
        <div class="card-header-custom">
            <h4>
                <i class="fas fa-boxes text-primary me-2"></i>
                Add New Inventory Item
            </h4>
        </div>
        
        <div class="card-body-custom">
            <form action="{{ route('inventory.store') }}" method="POST">
                @csrf
                
                <div class="form-grid">
                    <!-- Item Name -->
                    <div class="form-group form-group-full">
                        <label class="form-label">
                            <i class="fas fa-tag"></i> Item Name <span class="required">*</span>
                        </label>
                        <input type="text" name="item_name" class="form-control" required 
                               placeholder="Enter item name e.g., Sound System, Chairs, Books">
                    </div>
                    
                    <!-- Category -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-folder"></i> Category
                        </label>
                        <select name="category" class="form-select">
                            <option value="">Select Category</option>
                            <option value="Equipment">🎛️ Equipment</option>
                            <option value="Furniture">🪑 Furniture</option>
                            <option value="Books">📚 Books</option>
                            <option value="Office Supplies">📎 Office Supplies</option>
                            <option value="Music Instruments">🎸 Music Instruments</option>
                            <option value="Sound System">🔊 Sound System</option>
                            <option value="Other">📦 Other</option>
                        </select>
                    </div>
                    
                    <!-- Quantity & Price Row -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-hashtag"></i> Quantity <span class="required">*</span>
                        </label>
                        <input type="number" name="quantity" class="form-control" required 
                               placeholder="0" min="0" value="1">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-money-bill-wave"></i> Price (₱)
                        </label>
                        <input type="number" step="0.01" name="price" class="form-control" 
                               placeholder="0.00" min="0">
                        <div class="helper-text">
                            <i class="fas fa-info-circle"></i> Optional - leave empty if not applicable
                        </div>
                    </div>
                    
                    <!-- Status - Better UI -->
                    <div class="form-group form-group-full">
                        <label class="form-label">
                            <i class="fas fa-circle"></i> Status
                        </label>
                        <div class="status-options">
                            <div class="status-option active" data-status="available" onclick="selectStatus('available')">
                                <i class="fas fa-check-circle"></i> Available
                            </div>
                            <div class="status-option" data-status="damaged" onclick="selectStatus('damaged')">
                                <i class="fas fa-exclamation-triangle"></i> Damaged
                            </div>
                            <div class="status-option" data-status="lost" onclick="selectStatus('lost')">
                                <i class="fas fa-times-circle"></i> Lost
                            </div>
                        </div>
                        <input type="hidden" name="status" id="statusInput" value="available">
                    </div>
                    
                    <!-- Description - Full Width -->
                    <div class="form-group form-group-full">
                        <label class="form-label">
                            <i class="fas fa-align-left"></i> Description
                        </label>
                        <textarea name="description" class="form-control" 
                                  placeholder="Enter item description, condition, location, or additional notes..."></textarea>
                        <div class="helper-text">
                            <i class="fas fa-pen"></i> Include details like brand, color, location, etc.
                        </div>
                    </div>
                </div>
                
                <div class="divider"></div>
                
                <div class="button-group">
                    <a href="{{ route('inventory.index') }}" class="btn-cancel">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i> Save Inventory Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function selectStatus(status) {
        // Update hidden input
        document.getElementById('statusInput').value = status;
        
        // Update UI
        document.querySelectorAll('.status-option').forEach(option => {
            option.classList.remove('active');
            if (option.getAttribute('data-status') === status) {
                option.classList.add('active');
            }
        });
    }
</script>
@endsection