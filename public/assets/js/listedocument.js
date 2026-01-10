// Document data
const documents = [
    {
        id: 1,
        title: "Bupont Jouvet",
        author: "Altes Dados",
        date: "2023-12-15",
        status: "validated",
        statusText: "Validé",
        type: "contract"
    },
    {
        id: 2,
        title: "Manuel dos Pincks",
        author: "Semant Lideron",
        date: "2023-11-01",
        status: "pending",
        statusText: "En attente",
        type: "manual"
    },
    {
        id: 3,
        title: "Judit Hosme",
        author: "Hallan-Parti",
        date: "2023-07-18",
        status: "validated",
        statusText: "Validé",
        type: "report"
    },
    {
        id: 4,
        title: "Webmotor API Guide",
        author: "Tech Solutions",
        date: "2023-09-22",
        status: "pending",
        statusText: "En attente",
        type: "manual"
    },
    {
        id: 5,
        title: "Rapport Annuel 2023",
        author: "Finance Dept",
        date: "2023-12-30",
        status: "validated",
        statusText: "Validé",
        type: "report"
    }
];

// Function to render documents in the table
function renderDocuments(docs) {
    const tableBody = document.getElementById('documentsTable');
    
    if (docs.length === 0) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="5" class="no-results">
                    <i class="fas fa-search" style="font-size: 24px; margin-bottom: 10px; display: block;"></i>
                    Aucun document trouvé. Essayez d'autres termes de recherche.
                </td>
            </tr>
        `;
        return;
    }
    
    tableBody.innerHTML = '';
    
    docs.forEach(doc => {
        const row = document.createElement('tr');
        
        // Determine status class
        let statusClass = 'status-pending';
        if (doc.status === 'validated') {
            statusClass = 'status-validated';
        } else if (doc.status === 'rejected') {
            statusClass = 'status-rejected';
        }
        
        row.innerHTML = `
            <td>${doc.title}</td>
            <td>${doc.author}</td>
            <td>${doc.date}</td>
            <td><span class="status ${statusClass}">${doc.statusText}</span></td>
            <td>
                <div class="actions">
                    <button class="action-btn view-btn" data-id="${doc.id}" title="Voir">
                        <i class="far fa-eye"></i>
                    </button>
                    <button class="action-btn edit-btn" data-id="${doc.id}" title="Éditer">
                        <i class="far fa-edit"></i>
                    </button>
                    <button class="action-btn delete-btn" data-id="${doc.id}" title="Supprimer">
                        <i class="far fa-trash-alt"></i>
                    </button>
                </div>
            </td>
        `;
        
        tableBody.appendChild(row);
    });
    
    // Add event listeners to action buttons
    document.querySelectorAll('.view-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const docId = this.getAttribute('data-id');
            viewDocument(docId);
        });
    });
    
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const docId = this.getAttribute('data-id');
            editDocument(docId);
        });
    });
    
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const docId = this.getAttribute('data-id');
            deleteDocument(docId);
        });
    });
}

// Function to view document
function viewDocument(docId) {
    const doc = documents.find(d => d.id == docId);
    if (doc) {
        alert(`📄 Visualisation du document:\n\n📌 Titre: ${doc.title}\n👤 Auteur: ${doc.author}\n📅 Date: ${doc.date}\n✅ Statut: ${doc.statusText}\n📁 Type: ${getTypeText(doc.type)}`);
    }
}

// Helper function to get type text
function getTypeText(type) {
    const typeMap = {
        'contract': 'Contrat',
        'report': 'Rapport',
        'manual': 'Manuel',
        'other': 'Autre'
    };
    return typeMap[type] || 'Non spécifié';
}

// Function to edit document
function editDocument(docId) {
    const doc = documents.find(d => d.id == docId);
    if (doc) {
        const newTitle = prompt("Modifier le titre du document:", doc.title);
        if (newTitle !== null && newTitle.trim() !== '') {
            const oldTitle = doc.title;
            doc.title = newTitle.trim();
            
            // Ask for status change
            const newStatus = prompt("Modifier le statut (1=Validé, 2=En attente, 3=Rejeté):", 
                doc.status === 'validated' ? '1' : doc.status === 'pending' ? '2' : '3');
            
            if (newStatus === '1') {
                doc.status = 'validated';
                doc.statusText = 'Validé';
            } else if (newStatus === '2') {
                doc.status = 'pending';
                doc.statusText = 'En attente';
            } else if (newStatus === '3') {
                doc.status = 'rejected';
                doc.statusText = 'Rejeté';
            }
            
            filterDocuments(); // Appliquer les filtres actuels
            showNotification(`✅ Document "${oldTitle}" modifié avec succès.`);
        }
    }
}

// Function to delete document
function deleteDocument(docId) {
    const docIndex = documents.findIndex(d => d.id == docId);
    if (docIndex !== -1) {
        const docTitle = documents[docIndex].title;
        const confirmDelete = confirm(`Êtes-vous sûr de vouloir supprimer le document "${docTitle}" ?`);
        if (confirmDelete) {
            const deletedDoc = documents.splice(docIndex, 1)[0];
            filterDocuments(); // Appliquer les filtres actuels
            showNotification(`🗑️ Document "${deletedDoc.title}" supprimé avec succès.`);
        }
    }
}

// Function to add a new document
function addNewDocument() {
    const title = prompt("📝 Titre du nouveau document:");
    if (!title || title.trim() === '') {
        showNotification("⚠️ Le titre ne peut pas être vide.");
        return;
    }
    
    const author = prompt("👤 Auteur du document:");
    if (!author || author.trim() === '') {
        showNotification("⚠️ L'auteur ne peut pas être vide.");
        return;
    }
    
    const today = new Date();
    const defaultDate = today.toISOString().split('T')[0];
    const date = prompt("📅 Date (YYYY-MM-DD):", defaultDate);
    
    if (!date) {
        showNotification("⚠️ La date ne peut pas être vide.");
        return;
    }
    
    // Ask for document type
    const typeChoice = prompt("📁 Type de document (1=Contrat, 2=Rapport, 3=Manuel, 4=Autre):", "3");
    let docType = "manual";
    if (typeChoice === '1') docType = "contract";
    else if (typeChoice === '2') docType = "report";
    else if (typeChoice === '4') docType = "other";
    
    const newDoc = {
        id: documents.length > 0 ? Math.max(...documents.map(d => d.id)) + 1 : 1,
        title: title.trim(),
        author: author.trim(),
        date: date,
        status: "pending",
        statusText: "En attente",
        type: docType
    };
    
    documents.push(newDoc);
    
    // Après l'ajout, on affiche TOUS les documents
    clearFilters();
    
    showNotification(`✅ Document "${title}" ajouté avec succès.`);
}

// Function to filter documents
function filterDocuments() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
    const docType = document.getElementById('docType').value;
    const docStatus = document.getElementById('docStatus').value;
    const docDate = document.getElementById('docDate').value;
    
    let filteredDocs = documents.filter(doc => {
        // 1. Filter by search term in title (case insensitive)
        if (searchTerm && !doc.title.toLowerCase().includes(searchTerm)) {
            return false;
        }
        
        // 2. Filter by document type
        if (docType !== 'all' && doc.type !== docType) {
            return false;
        }
        
        // 3. Filter by status
        if (docStatus !== 'all' && doc.status !== docStatus) {
            return false;
        }
        
        // 4. Filter by date
        if (docDate && doc.date !== docDate) {
            return false;
        }
        
        return true;
    });
    
    renderDocuments(filteredDocs);
    
    // Show message if search returned no results
    if (searchTerm && filteredDocs.length === 0) {
        showNotification(`🔍 Aucun résultat pour "${searchTerm}"`);
    }
}

// Function to show notification
function showNotification(message) {
    // Remove existing notification if any
    const existingNotification = document.querySelector('.notification');
    if (existingNotification) {
        existingNotification.remove();
    }
    
    // Create notification element
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: #10b981;
        color: white;
        padding: 15px 20px;
        border-radius: 6px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 1000;
        font-weight: 600;
        animation: fadeIn 0.3s, fadeOut 0.3s 2.7s;
        max-width: 400px;
        word-wrap: break-word;
    `;
    
    notification.textContent = message;
    document.body.appendChild(notification);
    
    // Remove notification after 3 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
    }, 3000);
}

// Function to clear all filters
function clearFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('docType').value = 'all';
    document.getElementById('docStatus').value = 'all';
    document.getElementById('docDate').value = '';
    
    // Afficher tous les documents
    renderDocuments(documents);
    
    showNotification("🧹 Filtres réinitialisés - Tous les documents sont visibles");
}

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    // Render initial documents
    renderDocuments(documents);
    
    // Add event listeners for search
    document.getElementById('searchBtn').addEventListener('click', filterDocuments);
    
    // Search on Enter key press
    document.getElementById('searchInput').addEventListener('keyup', function(event) {
        if (event.key === 'Enter') {
            filterDocuments();
        }
    });
    
    // Add button for adding document
    document.getElementById('addDocumentBtn').addEventListener('click', addNewDocument);
    
    // Clear filters button
    document.getElementById('clearFiltersBtn').addEventListener('click', clearFilters);
    
    // Filter event listeners
    document.getElementById('docType').addEventListener('change', filterDocuments);
    document.getElementById('docStatus').addEventListener('change', filterDocuments);
    document.getElementById('docDate').addEventListener('change', filterDocuments);
    
    // SUPPRIMÉ : Les écouteurs d'événements qui bloquaient la navigation
    // document.querySelectorAll('.menu-item a').forEach(item => {
    //     item.addEventListener('click', function(e) {
    //         e.preventDefault();  // ← CE LIGNE EMPÊCHAIT LA REDIRECTION !
    //         
    //         // Remove active class from all menu items
    //         document.querySelectorAll('.menu-item').forEach(menuItem => {
    //             menuItem.classList.remove('active');
    //         });
    //         
    //         // Add active class to clicked menu item
    //         this.parentElement.classList.add('active');
    //         
    //         // Show notification
    //         const menuText = this.textContent.trim();
    //         showNotification(`📍 ${menuText}`);
    //     });
    // });
    
    // Version corrigée pour le menu (si vous voulez garder l'effet visuel)
    document.querySelectorAll('.menu-item').forEach(menuItem => {
        menuItem.addEventListener('click', function(e) {
            // On ne bloque PAS la navigation pour les liens
            if (this.querySelector('a')) {
                // La navigation se fera normalement via le href
                // On peut juste ajouter la classe active visuellement
                document.querySelectorAll('.menu-item').forEach(item => {
                    item.classList.remove('active');
                });
                this.classList.add('active');
            }
        });
    });
    
    console.log("Application Gest-Docs chargée avec succès !");
});