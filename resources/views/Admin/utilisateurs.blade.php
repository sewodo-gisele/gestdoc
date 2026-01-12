@extends('layouts.app')

@section('content')
<style>
    /* Section Container */
    .user-management-section {
        padding: 20px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin: 20px 0;
    }

    /* Titre */
    .section-title {
        color: #2d3748;
        font-size: 1.5rem;
        margin-bottom: 20px;
        font-weight: 700;
        border-left: 5px solid #3b82f6;
        padding-left: 15px;
    }

    /* Table Base Styles */
    .user-table {
        width: 100%;
        border-collapse: collapse;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        text-align: left;
    }

    .user-table thead {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }

    .user-table th {
        padding: 12px 15px;
        color: #495057;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .user-table td {
        padding: 12px 15px;
        vertical-align: middle;
        border-bottom: 1px solid #edf2f7;
        color: #2d3748;
    }

    .user-table tbody tr:hover {
        background-color: #f1f5f9;
        transition: background-color 0.2s ease;
    }

    /* Status Badges */
    .status {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: bold;
        display: inline-block;
    }

    .status.active {
        background-color: #d1fae5;
        color: #065f46;
    }

    .status.pending {
        background-color: #fef3c7;
        color: #92400e;
    }

    /* Action Buttons */
    .btn-action {
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.85rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-edit {
        background-color: #3b82f6;
        color: white;
        margin-right: 5px;
    }

    .btn-edit:hover {
        background-color: #2563eb;
    }

    .btn-delete {
        background-color: #ef4444;
        color: white;
    }

    .btn-delete:hover {
        background-color: #dc2626;
    }

    /* Footer */
    .footer-copy {
        text-align: center;
        margin-top: 30px;
        padding: 20px;
        color: #718096;
        font-size: 0.9rem;
        border-top: 1px solid #edf2f7;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .user-table {
            display: block;
            overflow-x: auto;
        }
    }
</style>

<section class="user-management-section">

    <div class="header" style="
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 24px 32px;
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.03);
    backdrop-filter: blur(10px);
    position: relative;
    overflow: hidden;
">
    
    <!-- Background decorative elements -->
    <div style="
        position: absolute;
        top: -50%;
        right: -10%;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.08) 0%, transparent 70%);
        z-index: 0;
    "></div>
    
    <h2 style="
        margin: 0;
        font-size: 28px;
        font-weight: 700;
        background: linear-gradient(90deg, #1e3a8a 0%, #3b82f6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        position: relative;
        z-index: 1;
        letter-spacing: -0.5px;
    ">
        Liste des utilisateurs
    </h2>
    
    <div class="user-info" style="
        display: flex;
        align-items: center;
        gap: 16px;
        position: relative;
        z-index: 1;
    ">
        
        <div style="
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 4px;
        ">
            <span style="
                font-weight: 600;
                color: #1f2937;
                font-size: 15px;
                letter-spacing: 0.3px;
            ">
                
            </span>
        </div>
        
        <div class="user-avatar" style="
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 18px;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
            border: 3px solid white;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        ">
           
            <div style="
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                height: 20%;
                background: linear-gradient(to top, rgba(255,255,255,0.2), transparent);
            "></div>
        </div>
        
        <!-- Notification indicator -->
        <div style="
            position: absolute;
            top: -4px;
            right: -4px;
            width: 12px;
            height: 12px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 50%;
            border: 2px solid white;
            z-index: 2;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        "></div>
        
    </div>
    
    <!-- Subtle hover effects -->
    <style>
        .user-avatar:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
        }
        
        .user-avatar:active {
            transform: translateY(0);
        }
    </style>
    
</div>
    
    <table class="user-table">
        <thead>
            <tr>
                <th>Nom d'utilisateur</th>
                <th>Email</th>
                <th>Rôle</th>
               
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role->name ?? 'Utilisateur' }}</td>
               
                <td>
                  

                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action btn-delete" onclick="return confirm('Supprimer cet utilisateur ?')">
                            <i class="fas fa-trash-alt"></i> Supprimer
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</section>

<footer class="footer-copy">
    &copy; 2025 Gest-Docs Tous droits réservés.
</footer>

@endsection