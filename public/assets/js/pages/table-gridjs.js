/*
Template Name: Konrix - Responsive 5 Admin Dashboard
Author: CoderThemes
Website: https://coderthemes.com/
Contact: support@coderthemes.com
File: datatable js
*/


class GridDatatable {

    init() {
        this.basicTableInit();
    }

    basicTableInit() {

        //draft list all-drafts-table
            //  if (document.getElementById("all-drafts-table"))
            // new gridjs.Grid({
            //     columns: [{
            //         name: 'ID',
            //         formatter: (function (cell) {
            //             return gridjs.html('<span class="fw-semibold">' + cell + '</span>');
            //         })
            //     },
            //         "Name", "Phone Number",
                   
            //     {
            //         name: 'Actions',
            //         width: '120px',
            //         formatter: (function (cell) {
            //             return gridjs.html("<a href='#' class='text-reset text-decoration-underline'>" + "<a href='tickets/show' class='me-0.5'> <i class='mgc_edit_line text-lg'></i> </a> " + " <a href='javascript:void(0);' class='ms-0.5'> <i class='mgc_delete_line text-xl'></i> </a>"  + " <a href='javascript:void(0);' class='ms-0.5'> <i class='mgc_view_line text-xl'></i> </a>" + " <a href='#' class='ms-0.5'> <i class='mgc_send_line text-xl' onclick='openModal()' id='openModal'></i> </a>"+ "</a>");
            //         })
            //     },
            //     ],
            //     pagination: {
            //         limit: 5
            //     },
            //     sort: true,
            //     search: true,
            //     data: [
            //         ["01", "Jonathan", "07067317819"],
            //         ["02", "Harold", "07067317819"],
            //         ["03", "Shannon", "07067317819"],
            //         ["04", "Robert", "07067317819"],
            //         ["05", "Noel", "07067317819"],
            //         ["06", "Traci",  "07067317819"],
            //         ["07", "Kerry", "07067317819"],
            //         ["08", "Patsy", "07067317819"],
            //         ["09", "Cathy", "07067317819"],
            //         ["10", "Tyrone", "07067317819"],
            //     ]
            // }).render(document.getElementById("all-drafts-table"));

           async function initializeDraftsTable() {
            try {
                // Fetch drafts from Laravel backend
                const response = await fetch('tickets/data-drafts', { method: 'GET' }, 'data-drafts")', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                console.log("RAW RESPONSE", response);

                if (!response.ok) {
                    throw new Error('Failed to fetch drafts');
                }
                
                const drafts = await response.json();

                console.log("DRAFTS", drafts);
                
                // Format the full name
                const formatName = (draft) => {
                    let name = draft.fname || '';
                    if (draft.mname) name += ` ${draft.mname}`;
                    if (draft.lname) name += ` ${draft.lname}`;
                    return name.trim();
                };
                
                // Format phone numbers (join multiple numbers with comma)
                const formatPhoneNumbers = (phoneNumbers) => {
                    return phoneNumbers.map(pn => pn.number).join(', ');
                };
                
                // Initialize GridJS table if element exists
                if (document.getElementById("all-drafts-table")) {
                    new gridjs.Grid({
                        columns: [
                            {
                                name: 'ID',
                                formatter: (cell) => gridjs.html(`<span class="fw-semibold">${cell}</span>`)
                            },
                            {
                                name: 'Name',
                                formatter: (cell) => cell || 'N/A'
                            }, 
                            {
                                name: 'Phone Number',
                                formatter: (cell) => cell || 'N/A'
                            },
                            {
                                name: 'Actions',
                                width: '120px',
                                formatter: (_, row) => gridjs.html(`
                                    <div class="flex items-center">
                                        <a href="/drafts/${row.cells[0].data}/edit" class="text-warning me-2">
                                            <i class="mgc_edit_line text-lg"></i>
                                        </a>
                                        <a href="javascript:void(0);" onclick="deleteDraft('${row.cells[0].data}')" class="text-danger me-2">
                                            <i class="mgc_delete_line text-xl"></i>
                                        </a>
                                        <a href="/drafts/${row.cells[0].data}" class="text-info me-2">
                                            <i class="mgc_view_line text-xl"></i>
                                        </a>
                                        <a href="javascript:void(0);" onclick="openSendModal('${row.cells[0].data}')" class="text-primary">
                                            <i class="mgc_send_line text-xl"></i>
                                        </a>
                                    </div>
                                `)
                            }
                        ],
                        pagination: {
                            limit: 5
                        },
                        sort: true,
                        search: true,
                        data: drafts.map(draft => [
                            draft.id,
                            formatName(draft),
                            draft.phone_numbers ? formatPhoneNumbers(draft.phone_numbers) : (draft.phone_number || 'N/A'),
                            '' // Actions column will be handled by the formatter
                        ])
                    }).render(document.getElementById("all-drafts-table"));
                }
            } catch (error) {
                console.error('Error initializing drafts table:', error);
                // Show error message to user
                const tableContainer = document.getElementById("all-drafts-table");
                if (tableContainer) {
                    tableContainer.innerHTML = `
                        <div class="alert alert-danger">
                            Failed to load drafts. Please try again later.
                        </div>
                    `;
                }
            }
        }

// Call this function when the page loads
//document.addEventListener('DOMContentLoaded', function() {
    initializeDraftsTable();
//});

// Delete draft function
function deleteDraft(draftId) {
    if (confirm('Are you sure you want to delete this draft?')) {
        fetch(`/drafts/${draftId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                // Refresh the table after successful deletion
                initializeDraftsTable();
            } else {
                alert('Failed to delete draft');
            }
        }).catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the draft');
        });
    }
}

// Open send modal function
function openSendModal(draftId) {
    // Implement your modal opening logic here
    console.log('Opening send modal for draft:', draftId);
    // Example: $('#sendModal').modal('show'); if using Bootstrap
}



        // Tickets Table - Customers
        async function initializeCustomerTicketsTable() {
  const tableContainer = document.getElementById("customer-tickets-table");
  const loadingIndicator = document.getElementById("loading-indicator");
  
  try {
    // Show loading indicator
    if (loadingIndicator) loadingIndicator.classList.remove('hidden');
    if (tableContainer) tableContainer.innerHTML = '';
    
    // Fetch tickets from your Laravel endpoint
    const response = await fetch('tickets/customer-tickets', {
      headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer ' + localStorage.getItem('auth_token')
      }
    });
    
    if (!response.ok) {
      throw new Error('Failed to fetch tickets: ' + response.statusText);
    }
    
    const tickets = await response.json();
    console.log('Tickets data:', tickets);
    
    // Initialize GridJS table if element exists
    if (tableContainer) {
      new gridjs.Grid({
        columns: [
          {
            name: 'ID',
            formatter: (cell) => gridjs.html(`<span class="fw-semibold">${cell}</span>`),
            sort: true
          },
          {
            name: 'Support Agent',
            formatter: (cell) => {
                // Check if identity exists and has at least one name
                const hasIdentity = cell?.identity && cell.identity.length > 0 && cell.identity[0].name;
                
                // If identity exists, use the first identity name
                if (hasIdentity) {
                    return gridjs.html(`<span>${cell.identity[0].name}</span>`);
                }
                // Otherwise use the support agent's first and last name
                else {
                    const supportName = cell?.fname || cell?.user?.fname || '';
                    const supportLName = cell?.lname || cell?.user?.lname || '';
                    const fullName = `${supportName} ${supportLName}`.trim();
                    return gridjs.html(`<span>${fullName || 'N/A'}</span>`);
                }
            },
            sort: true
        },
        //   {
        //     name: 'Subject',
        //     formatter: (cell) => gridjs.html(`<span>${cell || 'N/A'}</span>`),
        //     sort: true
        //   },
          {
            name: 'Description',
            formatter: (cell) => gridjs.html(`<span>${cell || 'N/A'}</span>`),
            sort: true
          },
          {
            name: 'Phone Numbers',
            formatter: (cell) => {
              // Handle both array of objects and array of strings
              const phones = Array.isArray(cell) 
                ? cell.map(pn => pn?.number || pn).join(', ')
                : 'N/A';
              return gridjs.html(`<span>${phones || 'N/A'}</span>`);
            }
          },
          {
            name: 'Status',
            formatter: (cell) => {
              //let bgClass, textClass;
              let bgClass, textClass, displayStatus;
                const status = cell?.toLowerCase();
                if (status === 'assigned' || status === 'rejected') {
                    displayStatus = 'Awaiting Response';
                }else if(status === 'open'){

                    displayStatus = 'Open';
                } else if(status === 'resolved'){

                    displayStatus = 'Resolved';
                } else if(status === 'processing'){

                    displayStatus = 'processing';
                }
                 else {
                    displayStatus = cell || 'N/A';
                }
              switch (cell?.toLowerCase()) {
                case 'Processing': 
                  bgClass = 'bg-primary-subtle'; 
                  textClass = 'text-primary';
                  break;
                case 'assigned':
                  bgClass = 'bg-success-subtle';
                  textClass = 'text-primary';
                  break;
                case 'open':
                  bgClass = 'bg-warning-subtle';
                  textClass = 'text-primary';
                  break;
                case 'resolved':
                  bgClass = 'bg-success-subtle';
                  textClass = 'text-success';
                  break;
                default:
                  bgClass = 'bg-secondary-subtle';
                  textClass = 'text-secondary';
              }
              return gridjs.html(`<span class="badge ${bgClass} ${textClass}">${displayStatus}</span>`);
            },
            sort: {
              compare: (a, b) => {
                const statusOrder = { assigned: 1, resolved: 2, process: 3, open: 4, rejected: 5 };
                return (statusOrder[a?.toLowerCase()] || 99) - (statusOrder[b?.toLowerCase()] || 99);
              }
            }
          },
          {
            name: 'Created At',
            formatter: (cell) => cell ? new Date(cell).toLocaleDateString() : 'N/A',
            sort: true
          },
          {
            name: 'Actions',
            width: '150px',
            formatter: (cell, row) => {
              const ticketId = row.cells[0].data;
              const status = row.cells[4].data?.toLowerCase();
              
              // Base actions (edit, delete, view)
              let actionsHTML = `
                <div class="flex items-center">
                  <a href="/dashboard/tickets/${ticketId}/edit-ticket" class="text-warning me-2" title="Edit">
                    <i class="mgc_edit_line text-lg"></i>
                  </a>
                  <a href="javascript:void(0);" onclick="deleteTicket('${ticketId}')" class="text-danger me-2" title="Delete">
                    <i class="mgc_delete_line text-xl"></i>
                  </a>
              `;
              
              // Add review button only for completed tickets
              if (status === 'resolved') {
                actionsHTML += `
                  <a href="javascript:void(0);" onclick="openReviewModal('${ticketId}')" class="text-purple-600" title="Write Review">
                    <i class="mgc_star_line text-xl"></i>
                  </a>
                `;
              }
              
              actionsHTML += `</div>`;
              return gridjs.html(actionsHTML);
            }
          }
        ],
        pagination: {
          limit: 10
        },
        sort: true,
        search: true,
        data: tickets.map(ticket => [
          ticket.id,
          {
            ...ticket.support,  // Spread the support object
            identity: ticket.support?.identity || [], // Include identities if they exist
            user: ticket.support?.user || {} // Include user details
            },
          ticket.description,
          ticket.phone_numbers || [],
          ticket.status,
          ticket.created_at,
          '' // Actions column
        ])
      }).render(tableContainer);
    }
  } catch (error) {
    console.error('Error initializing tickets table:', error);
    if (tableContainer) {
      tableContainer.innerHTML = `
        <div class="alert alert-danger p-4">
          <h4 class="alert-heading">Failed to load tickets</h4>
          <p>${error.message}</p>
          <button onclick="initializeCustomerTicketsTable()" class="btn btn-sm btn-primary mt-2">
            Retry
          </button>
        </div>
      `;
    }
  } finally {
    // Hide loading indicator
    if (loadingIndicator) loadingIndicator.classList.add('hidden');
  }
}

async function initializeCustomerOnbehalfTicketsTable() {
    const tableContainer = document.getElementById("customer-tickets-onbehalf");
    const loadingIndicator = document.getElementById("loading-indicator");
    const bulkActionBtn = document.getElementById("bulk-action-btn");;
    
    try {
        // Show loading indicator
        if (loadingIndicator) loadingIndicator.classList.remove('hidden');
        if (tableContainer) tableContainer.innerHTML = '';
        
        // Hide bulk action button initially
        if (bulkActionBtn) bulkActionBtn.classList.add('hidden');
        
        // Fetch tickets from your Laravel endpoint
        const response = await fetch('/dashboard/tickets/get-tickets-onbehalf', {
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('auth_token')
            }
        });
        
        if (!response.ok) {
            throw new Error('Failed to fetch tickets: ' + response.statusText);
        }
        
        const tickets = await response.json();
        console.log('Tickets UPLO ONBELAH:', tickets);
        
        // Track selected ticket IDs
        // const selectedQualityControlTickets = new Set();
         // Initialize selected tickets set on window object if it doesn't exist
        if (!window.selectedTickets) {
            window.selectedTickets = new Set();
        }
        
        // Initialize GridJS table if element exists
        if (tableContainer) {
            const grid = new gridjs.Grid({
                columns: [
                    
                    {
                        name: '#',
                        formatter: (cell) => gridjs.html(`<span class="fw-semibold">${cell}</span>`),
                        sort: true,
                        width: '80px'
                    },
                    {
                        name: 'Description',
                        formatter: (cell) => gridjs.html(`<span>${cell || 'N/A'}</span>`),
                        sort: true
                    },
                    {
                        name: 'Status',
                        formatter: (cell) => {
                            let bgClass, textClass, displayStatus;
                            const status = cell?.toLowerCase();
                            if (status === 'assigned') {
                                displayStatus = 'Awaiting Response';
                            }else if(status === 'open'){

                                displayStatus = 'Open';
                            } else if(status === 'resolved'){

                                displayStatus = 'Resolved';
                            } else if(status === 'processing'){

                                displayStatus = 'Processing';
                            }
                            else {
                                displayStatus = cell || 'N/A';
                            }
                            switch (cell?.toLowerCase()) {
                                case 'open': 
                                    bgClass = 'bg-primary-subtle'; 
                                    textClass = 'text-primary';
                                    break;
                                case 'assigned':
                                    bgClass = 'bg-success-subtle';
                                    textClass = 'text-primary';
                                    break;
                                case 'processing':
                                    bgClass = 'bg-warning-subtle';
                                    textClass = 'text-warning';
                                    break;
                                case 'rejected':
                                    bgClass = 'bg-warning-subtle';
                                    textClass = 'text-error';
                                    break;
                                case 'resolved':
                                    bgClass = 'bg-success-subtle';
                                    textClass = 'text-success';
                                    break;
                                default:
                                    bgClass = 'bg-secondary-subtle';
                                    textClass = 'text-secondary';
                            }
                            return gridjs.html(`<span class="badge ${bgClass} ${textClass}">${displayStatus}</span>`);
                        },
                        sort: {
                            compare: (a, b) => {
                                const statusOrder = { assign: 1, resolved: 2, processing: 3, open: 4, rejected: 5 };
                                return (statusOrder[a?.charAt(0).toUpperCase() + text.slice(1)] || 99) - (statusOrder[b?.charAt(0).toUpperCase() + text.slice(1)] || 99);
                            }
                        }
                    },
                    {
                        name: 'Created At',
                        formatter: (cell) => cell ? new Date(cell).toLocaleDateString() : 'N/A',
                        sort: true
                    },
                    {
                        name: 'Actions',
                        width: '100px',
                        formatter: (cell, row) => {
                            const ticketId = row.cells[5].data;
                            
                            // <a href="/dashboard/tickets/${ticketId}/edit-ticket" class="text-warning me-2" title="Edit">
                            //             <i class="mgc_edit_line text-lg"></i>
                            //         </a>
                            let actionsHTML = `
                                <div class="flex items-center">
                                    
                                    <a href="javascript:void(0);" onclick="deleteTicket('${ticketId}')" class="text-danger me-2" title="Delete">
                                        <i class="mgc_delete_line text-xl"></i>
                                    </a>
                                    <a href="/dashboard/tickets/view-single-ticket/${ticketId}" class="text-primary me-2" title="View">
                                        <i class="mgc_eye_2_line text-xl"></i>
                                    </a>
                            `;
                            
                            // if (status === 'completed') {
                            //     actionsHTML += `
                            //         <a href="javascript:void(0);" onclick="openReviewModal('${ticketId}')" class="text-purple-600" title="Write Review">
                            //             <i class="mgc_star_line text-xl"></i>
                            //         </a>
                            //     `;
                            // }
                            
                            actionsHTML += `</div>`;
                            return gridjs.html(actionsHTML);
                        }
                    },
                    // Checkbox column for multi-select
                     {
                        name: '',
                        width: '40px',
                        formatter: (cell, row) => {
                            const ticketId = row.cells[5].data; // First column has the ID
                            return gridjs.html(`
                                <input type="checkbox" 
                                    class="ticket-checkbox" 
                                    data-id="${ticketId}"
                                    onclick="window.toggleTicketSelection(${ticketId})"
                                    ${window.selectedTickets.has(ticketId) ? 'checked' : ''}>
                            `);
                        }
                    },
                    // Hidden ID column (not visible but in data)
                    {
                        name: 'ID',
                        hidden: true,
                        id: 'ticketId'
                    },
                ],
                pagination: {
                    limit: 10
                },
                sort: true,
                search: true,
                data: tickets.map((ticket, index) => [
                    //'', // Empty cell for checkbox
                    index + 1,
                    ticket.description || 'N/A',
                    ticket.status || 'N/A',
                    ticket.created_at || 'N/A',
                    '', // Actions column
                     ticket.id, // First column - ID (used in checkbox)
                     ticket.id, // Second column - hidden ID
                ])
            }).render(tableContainer);
            
            // Add event listener for checkboxes
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('ticket-checkbox')) {
                    const ticketId = e.target.dataset.id;
                    if (e.target.checked) {
                        selectedTickets.add(ticketId);
                    } else {
                        selectedTickets.delete(ticketId);
                    }
                    
                    // Show/hide bulk action button based on selection count
                    if (bulkActionBtn) {
                        if (selectedTickets.size >= 2) {
                            bulkActionBtn.classList.remove('hidden');
                        } else {
                            bulkActionBtn.classList.add('hidden');
                        }
                    }
                }
            });
            
            // Add custom export buttons
            const exportButtons = document.createElement('div');
            exportButtons.className = 'mb-3 flex gap-2';
            exportButtons.innerHTML = `
                <button class="btn btn-outline-primary btn-sm export-csv">
                    <i class="mgc_download_2_line me-1"></i> Export CSV
                </button>
                <button class="btn btn-outline-danger btn-sm export-pdf">
                    <i class="mgc_download_2_line me-1"></i> Export PDF
                </button>
                <button id="bulk-action-btn" class="btn btn-outline-success btn-sm hidden" 
                        onclick="updateSelectedTickets()">
                    <i class="mgc_check_line me-1"></i> Update Selected (${selectedTickets.size})
                </button>
            `;
            tableContainer.prepend(exportButtons);

           
            
            // // Export functionality
            document.querySelector('.export-csv').addEventListener('click', () => {
                grid.plugins.export.csv();
            });
            
            document.querySelector('.export-pdf').addEventListener('click', () => {
                grid.plugins.export.pdf();
            });
        }
    } catch (error) {
        console.error('Error initializing tickets table:', error);
        if (tableContainer) {
            tableContainer.innerHTML = `
                <div class="alert alert-danger p-4">
                    <h4 class="alert-heading">Failed to load tickets</h4>
                    <p>${error.message}</p>
                    <button onclick="initializeCustomerOnbehalfTicketsTable()" class="btn btn-sm btn-primary mt-2">
                        Retry
                    </button>
                </div>
            `;
        }
    } finally {
        if (loadingIndicator) loadingIndicator.classList.add('hidden');
    }
}

  async function initializeQualityControlTicketsTable() {
    const tableContainer = document.getElementById("quality-control-tickets");
    const loadingIndicator = document.getElementById("loading-indicator");
    const bulkActionBtn = document.getElementById("bulk-action-btn");;
    
    try {
        // Show loading indicator
        if (loadingIndicator) loadingIndicator.classList.remove('hidden');
        if (tableContainer) tableContainer.innerHTML = '';
        
        // Hide bulk action button initially
        if (bulkActionBtn) bulkActionBtn.classList.add('hidden');
        
        // Fetch tickets from your Laravel endpoint
        const response = await fetch('tickets/quality-control-tickets', {
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('auth_token')
            }
        });
        
        if (!response.ok) {
            throw new Error('Failed to fetch tickets: ' + response.statusText);
        }
        
        const tickets = await response.json();
        console.log('Quality Control Tickets data:', tickets);
        
        // Track selected ticket IDs
        // const selectedQualityControlTickets = new Set();
         // Initialize selected tickets set on window object if it doesn't exist
        if (!window.selectedTickets) {
            window.selectedTickets = new Set();
        }
        
        // Initialize GridJS table if element exists
        if (tableContainer) {
            const grid = new gridjs.Grid({
                columns: [
                    
                    {
                        name: '#',
                        formatter: (cell) => gridjs.html(`<span class="fw-semibold">${cell}</span>`),
                        sort: true,
                        width: '80px'
                    },
                    {
                        name: 'Description',
                        formatter: (cell) => gridjs.html(`<span>${cell || 'N/A'}</span>`),
                        sort: true
                    },
                    {
                        name: 'Customer Name',
                        formatter: (cell) => {
                            const userName = cell?.user?.fname + ' ' + cell?.user?.lname || cell?.fname || 'N/A';
                            return gridjs.html(`<span>${userName}</span>`);
                        }
                    },
                    {
                        name: 'Review Comment',
                        formatter: (cell) => {
                            if (!cell || cell.length === 0) return 'N/A';
                            const comment = cell[0]?.comment || 'No comment';
                            return gridjs.html(`<span class="text-muted">${comment}</span>`);
                        }
                    },
                    {
                        name: 'Rating',
                        formatter: (cell) => {
                            if (!cell || cell.length === 0) return gridjs.html('<span>N/A</span>');
                            
                            const rating = cell[0]?.rating || 0;
                            const starRating = rating / 2;
                            const fullStars = Math.floor(starRating);
                            const hasHalfStar = starRating % 1 >= 0.5;
                            const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);
                            
                            let starsHtml = '';
                            
                            for (let i = 0; i < fullStars; i++) {
                                starsHtml += '<i class="mgc_star_fill text-warning"></i>';
                            }
                            
                            if (hasHalfStar) {
                                starsHtml += '<i class="mgc_star_half_fill text-warning"></i>';
                            }
                            
                            for (let i = 0; i < emptyStars; i++) {
                                starsHtml += '<i class="mgc_star_line text-warning"></i>';
                            }
                            
                            return gridjs.html(`<div class="d-flex">${starsHtml}</div>`);
                        }
                    },
                    {
                        name: 'Assigned To',
                        formatter: (cell) => {
                            const userName = cell?.user?.fname + ' ' + cell?.user?.lname || cell?.fname || 'N/A';
                            return gridjs.html(`<span>${userName}</span>`);
                        }
                    },
                    {
                        name: 'Status',
                        formatter: (cell) => {
                            let bgClass, textClass, displayStatus;
                            const status = cell?.toLowerCase();
                            if (status === 'assigned') {
                                displayStatus = 'Awaiting Response';
                            }else if(status === 'open'){

                                displayStatus = 'Open';
                            } else if(status === 'resolved'){

                                displayStatus = 'Resolved';
                            } else if(status === 'processing'){

                                displayStatus = 'Processing';
                            }
                            else {
                                displayStatus = cell || 'N/A';
                            }
                            switch (cell?.toLowerCase()) {
                                case 'open': 
                                    bgClass = 'bg-primary-subtle'; 
                                    textClass = 'text-primary';
                                    break;
                                case 'assigned':
                                    bgClass = 'bg-success-subtle';
                                    textClass = 'text-primary';
                                    break;
                                case 'processing':
                                    bgClass = 'bg-warning-subtle';
                                    textClass = 'text-warning';
                                    break;
                                case 'rejected':
                                    bgClass = 'bg-warning-subtle';
                                    textClass = 'text-error';
                                    break;
                                case 'resolved':
                                    bgClass = 'bg-success-subtle';
                                    textClass = 'text-success';
                                    break;
                                default:
                                    bgClass = 'bg-secondary-subtle';
                                    textClass = 'text-secondary';
                            }
                            return gridjs.html(`<span class="badge ${bgClass} ${textClass}">${displayStatus}</span>`);
                        },
                        sort: {
                            compare: (a, b) => {
                                const statusOrder = { assign: 1, resolved: 2, processing: 3, open: 4, rejected: 5 };
                                return (statusOrder[a?.charAt(0).toUpperCase() + text.slice(1)] || 99) - (statusOrder[b?.charAt(0).toUpperCase() + text.slice(1)] || 99);
                            }
                        }
                    },
                    {
                        name: 'Created At',
                        formatter: (cell) => cell ? new Date(cell).toLocaleDateString() : 'N/A',
                        sort: true
                    },
                    {
                        name: 'Actions',
                        width: '100px',
                        formatter: (cell, row) => {
                            const ticketId = row.cells[9].data;
                            const status = row.cells[6].data?.toLowerCase();

                            // <a href="/dashboard/tickets/${ticketId}/edit-ticket" class="text-warning me-2" title="Edit">
                            //             <i class="mgc_edit_line text-lg"></i>
                            //         </a>
                            let actionsHTML = `
                                <div class="flex items-center">
                                    
                                    <a href="javascript:void(0);" onclick="deleteTicket('${ticketId}')" class="text-danger me-2" title="Delete">
                                        <i class="mgc_delete_line text-xl"></i>
                                    </a>
                                    <a href="/dashboard/tickets/view-single-ticket/${ticketId}" class="text-primary me-2" title="View">
                                        <i class="mgc_eye_2_line text-xl"></i>
                                    </a>
                            `;
                            
                            // if (status === 'completed') {
                            //     actionsHTML += `
                            //         <a href="javascript:void(0);" onclick="openReviewModal('${ticketId}')" class="text-purple-600" title="Write Review">
                            //             <i class="mgc_star_line text-xl"></i>
                            //         </a>
                            //     `;
                            // }
                            
                            actionsHTML += `</div>`;
                            return gridjs.html(actionsHTML);
                        }
                    },
                    // Checkbox column for multi-select
                     {
                        name: '',
                        width: '40px',
                        formatter: (cell, row) => {
                            const ticketId = row.cells[9].data; // First column has the ID
                            const status = row.cells[6].data?.toLowerCase();
                            if (status === 'open' || status === 'rejected') {
                            return gridjs.html(`
                                <input type="checkbox" 
                                    class="ticket-checkbox" 
                                    data-id="${ticketId}"
                                    onclick="window.toggleTicketSelection(${ticketId})"
                                    ${window.selectedTickets.has(ticketId) ? 'checked' : ''}>
                            `);
                            }
                        }
                    },
                    // Hidden ID column (not visible but in data)
                    {
                        name: 'ID',
                        hidden: true,
                        id: 'ticketId'
                    },
                ],
                pagination: {
                    limit: 10
                },
                sort: true,
                search: true,
                data: tickets.map((ticket, index) => [
                    //'', // Empty cell for checkbox
                    index + 1,
                    ticket.description || 'N/A',
                    ticket.customer || { fname: 'N/A' },
                    ticket.review || [],
                    ticket.review || [],
                    ticket.support || { fname: 'N/A' },
                    ticket.status || 'N/A',
                    ticket.created_at || 'N/A',
                    '', // Actions column
                     ticket.id, // First column - ID (used in checkbox)
                     ticket.id, // Second column - hidden ID
                ])
            }).render(tableContainer);
            
            // Add event listener for checkboxes
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('ticket-checkbox')) {
                    const ticketId = e.target.dataset.id;
                    if (e.target.checked) {
                        selectedTickets.add(ticketId);
                    } else {
                        selectedTickets.delete(ticketId);
                    }
                    
                    // Show/hide bulk action button based on selection count
                    if (bulkActionBtn) {
                        if (selectedTickets.size >= 2) {
                            bulkActionBtn.classList.remove('hidden');
                        } else {
                            bulkActionBtn.classList.add('hidden');
                        }
                    }
                }
            });
            
            // Add custom export buttons
            const exportButtons = document.createElement('div');
            exportButtons.className = 'mb-3 flex gap-2';
            exportButtons.innerHTML = `
                <button class="btn btn-outline-primary btn-sm export-csv">
                    <i class="mgc_download_2_line me-1"></i> Export CSV
                </button>
                <button class="btn btn-outline-danger btn-sm export-pdf">
                    <i class="mgc_download_2_line me-1"></i> Export PDF
                </button>
                <button id="bulk-action-btn" class="btn btn-outline-success btn-sm hidden" 
                        onclick="updateSelectedTickets()">
                    <i class="mgc_check_line me-1"></i> Update Selected (${selectedTickets.size})
                </button>
            `;
            tableContainer.prepend(exportButtons);

           
            
            // // Export functionality
            document.querySelector('.export-csv').addEventListener('click', () => {
                grid.plugins.export.csv();
            });
            
            document.querySelector('.export-pdf').addEventListener('click', () => {
                grid.plugins.export.pdf();
            });
        }
    } catch (error) {
        console.error('Error initializing tickets table:', error);
        if (tableContainer) {
            tableContainer.innerHTML = `
                <div class="alert alert-danger p-4">
                    <h4 class="alert-heading">Failed to load tickets</h4>
                    <p>${error.message}</p>
                    <button onclick="initializeQualityControlTicketsTable()" class="btn btn-sm btn-primary mt-2">
                        Retry
                    </button>
                </div>
            `;
        }
    } finally {
        if (loadingIndicator) loadingIndicator.classList.add('hidden');
    }
}

// Function to update selected tickets
async function updateSelectedTickets() {
    const checkboxes = document.querySelectorAll('.ticket-checkbox:checked');
    const selectedIds = Array.from(checkboxes).map(checkbox => checkbox.dataset.id);
    
    if (selectedIds.length === 0) {
        alert('Please select at least one ticket');
        return;
    }
    
    // Show confirmation dialog
    if (!confirm(`Are you sure you want to update ${selectedIds.length} selected tickets?`)) {
        return;
    }
    
    try {
        const response = await fetch('/api/tickets/bulk-update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Authorization': 'Bearer ' + localStorage.getItem('auth_token')
            },
            body: JSON.stringify({
                ticket_ids: selectedIds,
                // Add any other update parameters you need
                status: 'resolved' // Example update
            })
        });
        
        const data = await response.json();
        
        if (!response.ok) {
            throw new Error(data.message || 'Failed to update tickets');
        }
        
        alert(`${selectedIds.length} tickets updated successfully!`);
        initializeQualityControlTicketsTable(); // Refresh the table
        
    } catch (error) {
        console.error('Error updating tickets:', error);
        alert('Failed to update tickets: ' + error.message);
    }
}


//Support Table

async function initializeSupportTicketsTable() {
    const tableContainer = document.getElementById("support-tickets-table");
    const loadingIndicator = document.getElementById("loading-indicator");
    const bulkActionBtn = document.getElementById("bulk-action-btn");
    
    try {
        // Show loading indicator
        if (loadingIndicator) loadingIndicator.classList.remove('hidden');
        if (tableContainer) tableContainer.innerHTML = '';
        
        // Hide bulk action button initially
        if (bulkActionBtn) bulkActionBtn.classList.add('hidden');
        
        // Fetch tickets from your Laravel endpoint
        const response = await fetch('tickets/support-tickets', {
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('auth_token')
            }
        });
        
        if (!response.ok) {
            throw new Error('Failed to fetch tickets: ' + response.statusText);
        }
        
        const tickets = await response.json();
        console.log('Support Tickets data:', tickets);
        
        // Track selected ticket IDs
        const selectedTickets = new Set();
        
        // Initialize GridJS table if element exists
        if (tableContainer) {
            const grid = new gridjs.Grid({
                columns: [
                    // Hidden ID column (not visible but in data)
                    {
                        name: 'ID',
                        hidden: true,
                        id: 'ticketId'
                    },
                    {
                        name: '#',
                        formatter: (cell) => gridjs.html(`<span class="fw-semibold">${cell}</span>`),
                        sort: true,
                        width: '80px'
                    },
                    {
                        name: 'Description',
                        formatter: (cell) => gridjs.html(`<span>${cell || 'N/A'}</span>`),
                        sort: true
                    },
                    {
                        name: 'Customer Name',
                        formatter: (cell) => {
                            // Handle different possible customer data structures
                            if (typeof cell === 'object') {
                                if (cell.user) {
                                    return gridjs.html(`<span>${cell.user.fname || ''} ${cell.user.lname || ''}</span>`);
                                } else if (cell.fname) {
                                    return gridjs.html(`<span>${cell.fname || ''} ${cell.lname || ''}</span>`);
                                }
                            }
                            return gridjs.html(`<span>N/A</span>`);
                        }
                    },
                    {
                        name: 'Note',
                        formatter: (cell) => {
                            if (!cell || cell.length === 0) return 'N/A';
                            // Handle if note is an array or a single string
                            const note = Array.isArray(cell) ? (cell[0]?.note || 'No Note') : cell;
                            return gridjs.html(`<span class="text-muted">${note}</span>`);
                        }
                    },  
                    {
                        name: 'Status',
                        formatter: (cell) => {
                        let bgClass, textClass, displayStatus;
                        const status = cell?.toLowerCase();
                        if (status === 'assigned') {
                            displayStatus = 'Awaiting Response';
                        }else if(status === 'open'){

                            displayStatus = 'Open';
                        } else if(status === 'resolved'){

                            displayStatus = 'Resolved';
                        } else if(status === 'processing'){

                            displayStatus = 'processing';
                        }
                        else {
                            displayStatus = cell || 'N/A';
                        }
                            // let bgClass, textClass;
                            // const status = cell?.toLowerCase();

                             switch (cell?.toLowerCase()) {
                                case 'open': 
                                    bgClass = 'bg-primary-subtle'; 
                                    textClass = 'text-primary';
                                    break;
                                case 'assigned':
                                    bgClass = 'bg-success-subtle';
                                    textClass = 'text-primary';
                                    break;
                                case 'processing':
                                    bgClass = 'bg-warning-subtle';
                                    textClass = 'text-warning';
                                    break;
                                case 'rejected':
                                    bgClass = 'bg-warning-subtle';
                                    textClass = 'text-error';
                                    break;
                                case 'resolved':
                                    bgClass = 'bg-success-subtle';
                                    textClass = 'text-success';
                                    break;
                                default:
                                    bgClass = 'bg-secondary-subtle';
                                    textClass = 'text-secondary';
                            }
                            return gridjs.html(`<span class="badge ${bgClass} ${textClass}">${displayStatus}</span>`);
                        },
                        sort: {
                            compare: (a, b) => {
                                const statusOrder = { assigned: 1, resolved: 2, processing: 3, open: 4, rejected: 5 };
                                return (statusOrder[a?.toLowerCase()] || 99) - (statusOrder[b?.toLowerCase()] || 99);
                            }
                        }
                    },
                    
                    {
                        name: 'Phone Numbers',
                        formatter: (cell) => {
                        // Handle both array of objects and array of strings
                        const phones = Array.isArray(cell) 
                            ? cell.map(pn => pn?.number || pn).join(', ')
                            : 'N/A';
                        return gridjs.html(`<span>${phones || 'N/A'}</span>`);
                        }
                    },
                    {
                        name: 'Created At',
                        formatter: (cell) => cell ? new Date(cell).toLocaleDateString() : 'N/A',
                        sort: true
                    },
                    {
                        name: 'Actions',
                        width: '150px',
                        formatter: (cell, row) => {
                            const ticketId = row.cells[0].data;
                            const status = row.cells[5].data?.toLowerCase(); // Status is now in column index 5

                            let actionsHTML = `
                                <div class="flex items-center">
                                    
                                     
                                     <a href="/dashboard/tickets/view-single-ticket/${ticketId}" class="text-primary me-2" title="View">
                                         <i class="mgc_eye_2_line text-xl"></i>
                                     </a>
                            `;
                            
                            if (status === 'open' || status === 'processing' || status === 'assigned') {
                                actionsHTML += `
                                    <a href="javascript:void(0);" onclick="showStatusUpdateModal('${ticketId}', '${status}')" class="text-warning me-2" title="Update Status">
                                         <i class="mgc_edit_line text-xl"></i>
                                     </a>
                                `;
                            }
                            
                            actionsHTML += `</div>`;
                            return gridjs.html(actionsHTML);
                       // }

                            // return gridjs.html(`
                            //     <div class="flex items-center">
                            //         <a href="javascript:void(0);" onclick="showStatusUpdateModal('${ticketId}', '${status}')" class="text-warning me-2" title="Update Status">
                            //             <i class="mgc_edit_line text-xl"></i>
                            //         </a>
                            //         <a href="/dashboard/tickets/view-single-ticket/${ticketId}" class="text-primary me-2" title="View">
                            //             <i class="mgc_eye_2_line text-xl"></i>
                            //         </a>
                            //     </div>
                            // `);
                        }
                    }
                ],
                pagination: {
                    limit: 10
                },
                sort: true,
                search: true,
                data: tickets.map((ticket, index) => [
                    ticket.id,               // [0] Hidden ID
                    index + 1,               // [1] # (serial number)
                    ticket.description,      // [2] Description
                    ticket.customer,        // [3] Customer (object)
                    ticket.notes || ticket.note, // [4] Note (handle both 'notes' and 'note')
                    ticket.status,           // [5] Status
                    ticket.phone_numbers || [], // [6] Phone Number
                    ticket.created_at,       // [7] Created At
                    ''                       // [8] Actions (empty, handled by formatter)
                ])
            }).render(tableContainer);
            
            // Rest of your code (event listeners, export buttons, etc.)
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('ticket-checkbox')) {
                    const ticketId = e.target.dataset.id;
                    if (e.target.checked) {
                        selectedTickets.add(ticketId);
                    } else {
                        selectedTickets.delete(ticketId);
                    }
                    
                    if (bulkActionBtn) {
                        if (selectedTickets.size >= 2) {
                            bulkActionBtn.classList.remove('hidden');
                        } else {
                            bulkActionBtn.classList.add('hidden');
                        }
                    }
                }
            });
            
            const exportButtons = document.createElement('div');
            exportButtons.className = 'mb-3 flex gap-2';
            exportButtons.innerHTML = `
                <button class="btn btn-outline-primary btn-sm export-csv">
                    <i class="mgc_download_2_line me-1"></i> Export CSV
                </button>
                <button class="btn btn-outline-danger btn-sm export-pdf">
                    <i class="mgc_download_2_line me-1"></i> Export PDF
                </button>
                <button id="bulk-action-btn" class="btn btn-outline-success btn-sm hidden" 
                        onclick="updateSelectedTickets()">
                    <i class="mgc_check_line me-1"></i> Update Selected (${selectedTickets.size})
                </button>
            `;
            tableContainer.prepend(exportButtons);
            
            document.querySelector('.export-csv').addEventListener('click', () => {
                console.log('grrrr', grid);

                grid.plugins.export.csv();
            });
            
            document.querySelector('.export-pdf').addEventListener('click', () => {
                grid.plugins.export.pdf();
            });
        }
    } catch (error) {
        console.error('Error initializing tickets table:', error);
        if (tableContainer) {
            tableContainer.innerHTML = `
                <div class="alert alert-danger p-4">
                    <h4 class="alert-heading">Failed to load tickets</h4>
                    <p>${error.message}</p>
                    <button onclick="initializeSupportTicketsTable()" class="btn btn-sm btn-primary mt-2">
                        Retry
                    </button>
                </div>
            `;
        }
    } finally {
        if (loadingIndicator) loadingIndicator.classList.add('hidden');
    }
}

  //invoice Table

  async function subscription() {
    const tableContainer = document.getElementById("table-viewInvoice");
    const loadingIndicator = document.getElementById("loading-indicator");
    
    try {
        // Show loading indicator
        if (loadingIndicator) loadingIndicator.classList.remove('hidden');
        if (tableContainer) tableContainer.innerHTML = '';
        
        // Fetch subscriptions from your Laravel endpoint
        const response = await fetch('/dashboard/invoices/subscriptions', {
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('auth_token')
            }
        });
        
        if (!response.ok) {
            throw new Error('Failed to fetch subscriptions: ' + response.statusText);
        }
        
        const data = await response.json();
        
        if (!data.success || !data.subscriptions) {
            throw new Error('Invalid data format from server');
        }
        
        const subscriptions = data.subscriptions;
        console.log('Subscription data:', subscriptions);
        
        // Initialize GridJS table if element exists
        if (tableContainer) {
            new gridjs.Grid({
                columns: [
                    {
                        name: 'ID',
                        formatter: (cell) => gridjs.html(`<span class="fw-semibold">${cell}</span>`)
                    },
                    // {
                    //     name: 'Type',
                    //     formatter: (cell) => cell || 'N/A'
                    // },
                    {
                        name: 'Email',
                        formatter: (cell, row) => {
                            // Assuming customer data is included in the relationship
                            const email = row.cells[2]?.data?.customer?.email || 'N/A';
                            return gridjs.html(`<a href="mailto:${email}">${email}</a>`);
                        }
                    },
                        {
                        name: 'Amount',
                        formatter: (cell) => {
                            // Format amount as Nigerian Naira (NGN)
                            // Handle null/undefined values by defaulting to 0
                            const amount = cell || 0;
                            return new Intl.NumberFormat('en-NG', {
                                style: 'currency',
                                currency: 'NGN',
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }).format(amount);
                        }
                    },
                    {
                        name: 'Company',
                        formatter: (cell, row) => {
                            // Assuming customer data is included in the relationship
                            const company = row.cells[2]?.data?.customer?.company || 'N/A';
                            return company;
                        }
                    },
                    {
                        name: 'Status',
                        formatter: (cell) => {
                            let bgClass = '';
                            let textClass = '';
                    
                            switch (cell?.toLowerCase()) {
                                case 'open':
                                    bgClass = 'bg-primary-subtle';
                                    textClass = 'text-primary';
                                    break;
                                case 'completed':
                                    bgClass = 'bg-success-subtle';
                                    textClass = 'text-success';
                                    break;
                                case 'pending':
                                    bgClass = 'bg-warning-subtle';
                                    textClass = 'text-warning';
                                    break;
                                case 'rejected':
                                    bgClass = 'bg-warning-subtle';
                                    textClass = 'text-danger';
                                    break;
                                default:
                                    bgClass = 'bg-secondary-subtle';
                                    textClass = 'text-secondary';
                            }
                    
                            return gridjs.html(
                                `<span class="badge ${bgClass} ${textClass}">${cell || 'N/A'}</span>`
                            );
                        }
                    },
                    {
                        name: 'Actions',
                        width: '120px',
                        formatter: (cell, row) => {
                            const subscriptionId = row.cells[0].data;
                            return gridjs.html(`
                                <div class="flex items-center">
                                    <a href="#" onclick="updateInvoice('${subscriptionId}')" class="text-warning me-2">
                                        <i class="mgc_edit_line text-lg"></i>
                                    </a>
                                    <a href="javascript:void(0);" onclick="deleteSubscription('${subscriptionId}')" class="text-danger me-2">
                                        <i class="mgc_delete_line text-xl"></i>
                                    </a>
                                    <a href="/dashboard/invoices/view/${subscriptionId}" class="text-primary">
                                        <i class="mgc_view_line text-xl"></i>
                                    </a>
                                </div>
                            `);
                        }
                    }
                ],
                pagination: {
                    limit: 5
                },
                sort: true,
                search: true,
                data: subscriptions.map(sub => [
                    sub.reference || 'N/A',          // ID (using reference)
                    //'Subscription',                  // Type (hardcoded as all are subscriptions)
                    sub.customer?.user?.email || 'N/A',                             // Email (will be extracted from customer in formatter)
                    sub.amount || 0,                 // Amount
                    sub,                             // Company (will be extracted from customer in formatter)
                    sub.status || 'N/A',            // Status
                    null                            // Actions (handled by formatter)
                ])
            }).render(tableContainer);
        }
    } catch (error) {
        console.error('Error loading subscriptions:', error);
        if (tableContainer) {
            tableContainer.innerHTML = `
                <div class="alert alert-danger p-4">
                    <h4 class="alert-heading">Failed to load subscriptions</h4>
                    <p>${error.message}</p>
                    <button onclick="subscription()" class="btn btn-sm btn-primary mt-2">
                        Retry
                    </button>
                </div>
            `;
        }
    } finally {
        if (loadingIndicator) loadingIndicator.classList.add('hidden');
    }
}

// Call the function when the page loads
subscription();

// Example action functions
function updateInvoice(id) {
    console.log('Update invoice:', id);
    // Implement your update logic here
}

function deleteSubscription(id) {
    if (confirm('Are you sure you want to delete this subscription?')) {
        console.log('Delete subscription:', id);
        // Implement your delete logic here
    }
}



// Call this when the page loads  
  initializeCustomerTicketsTable();
  initializeQualityControlTicketsTable();
  initializeCustomerOnbehalfTicketsTable();
  initializeSupportTicketsTable();

// Delete ticket function
function deleteTicket(ticketId) {
  if (confirm('Are you sure you want to delete this ticket?')) {
    fetch(`/tickets/${ticketId}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Accept': 'application/json'
      }
    })
    .then(response => {
      if (response.ok) {
        initializeCustomerTicketsTable(); // Refresh table
      } else {
        alert('Failed to delete ticket');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('An error occurred while deleting the ticket');
    });
  }
}


//feedback table

 if (document.getElementById("table-feedback")) {
                new gridjs.Grid({
                    columns: [
                        {
                            name: 'ID',
                            formatter: (cell) => {
                                return gridjs.html('<span class="fw-semibold">' + cell + '</span>');
                            }
                        },
                        "Assigned to",
                        {
                            name: 'Customer Name',
                            formatter: (cell) => {
                                return gridjs.html('<a href="">' + cell + '</a>');
                            }
                        },

                        "AVG Response Time", "Review",

                        {
                            name: 'Rating',
                            formatter: (cell) => {
                                // Convert number (1-10) to star rating (0.5-5 in 0.5 increments)
                                const starRating = cell / 2;
                                const fullStars = Math.floor(starRating);
                                const hasHalfStar = starRating % 1 >= 0.5;
                                const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);
                                
                                let starsHtml = '';
                                
                                // Add full stars
                                for (let i = 0; i < fullStars; i++) {
                                    starsHtml += '<i class="mgc_star_fill text-warning"></i>';
                                }
                                
                                // Add half star if needed
                                if (hasHalfStar) {
                                    starsHtml += '<i class="mgc_star_half_fill text-warning"></i>';
                                }
                                
                                // Add empty stars
                                for (let i = 0; i < emptyStars; i++) {
                                    starsHtml += '<i class="mgc_star_line text-warning"></i>';
                                }
                                
                                return gridjs.html(`<div class="d-flex">${starsHtml}</div>`);
                            }
                        },
                        "Status",
                        {
                            name: 'Actions',
                            width: '120px',
                            formatter: (cell) => {
                                return gridjs.html(`
                                    <a href='tickets/show' class='me-1'> 
                                        <i class='mgc_edit_line text-lg'></i> 
                                    </a>
                                    <a href='javascript:void(0);' class='me-1'> 
                                        <i class='mgc_delete_line text-lg'></i> 
                                    </a>
                                    <a href='javascript:void(0);'> 
                                        <i class='mgc_eye_2_line text-lg'></i>  <!-- View Icon -->
                                    </a>
                                `);
                            }
                        }
                    ],
                    pagination: {
                        limit: 5
                    },
                    sort: true,
                    search: true,
                    data: [
                        ["01", "Jonathan", "jonathan@example.com", "6Minuites", "Great service!", 10, "Completed"],
                        ["02", "Harold", "harold@example.com", "20Minuites", "Average experience", 6, "Pending"],
                        ["03", "Shannon", "shannon@example.com", "4Minuites", "Not satisfied", 2, "Completed"],
                        ["04", "Robert", "robert@example.com", "1Minuites", "Excellent work!", 9, "Completed"],
                        ["05", "Noel", "noel@example.com", "6Minuites", "Could be better", 5, "In Progress"],
                    ]
                }).render(document.getElementById("table-feedback"));
            }


        // async function initializeTicketsTable() {
        //     try {
        //         // Fetch tickets from Laravel backend
        //         const response = await fetch('my-ticket', { method: 'GET' }, 'my-ticket")', {
        //             headers: {
        //                 'Accept': 'application/json',
        //                 'X-Requested-With': 'XMLHttpRequest'
        //             }
        //         });
        //         console.log("RAW RESPONSE", response);

        //         if (document.getElementById("table-gridjs"))
        //     new gridjs.Grid({
        //         columns: [{
        //             name: 'ID',
        //             formatter: (function (cell) {
        //                 return gridjs.html('<span class="fw-semibold">' + cell + '</span>');
        //             })
        //         },
        //             "Name",
        //         {
        //             name: 'Email',
        //             formatter: (function (cell) {
        //                 return gridjs.html('<a href="">' + cell + '</a>');
        //             })
        //         },
        //             "Phone Number", "Company",
        //             {
        //                 name: 'Status',
        //                 formatter: function (cell) {
        //                     let bgClass = '';
        //                     let textClass = '';
                    
        //                     switch (cell.toLowerCase()) {
        //                         case 'open':
        //                             bgClass = 'bg-primary-subtle';
        //                             textClass = 'text-primary';
        //                             break;
        //                         case 'active':
        //                             bgClass = 'bg-success-subtle';
        //                             textClass = 'text-success';
        //                             break;
        //                         case 'pending':
        //                             bgClass = 'bg-warning-subtle';
        //                             textClass = 'text-warning';
        //                             break;
        //                             case 'completed':
        //                             bgClass = 'bg-success-subtle';
        //                             textClass = 'text-success';
        //                         default:
        //                             bgClass = 'bg-secondary-subtle';
        //                             textClass = 'text-secondary';
        //                     }
                    
        //                     return gridjs.html(
        //                         `<span class="badge ${bgClass} ${textClass}">${cell}</span>`
        //                     );
        //                 }
        //             },
        //         {
        //             name: 'Actions',
        //             width: '120px',
        //             formatter: (function (cell) {
        //                 return gridjs.html("<a href='#' class='text-reset text-decoration-underline'>" + "<a href='tickets/show' class='me-0.5'> <i class='mgc_edit_line text-lg'></i> </a> " + " <a href='javascript:void(0);' class='ms-0.5'> <i class='mgc_delete_line text-xl'></i> </a>"  + " <a href='javascript:void(0);' class='ms-0.5'> <i class='mgc_view_line text-xl'></i> </a>" + " <a href='#' class='ms-0.5'> <i class='mgc_comment_line text-xl' onclick='openModal()' id='openModal'></i> </a>"+ "</a>");
        //             })
        //         },
        //         ],
        //         pagination: {
        //             limit: 5
        //         },
        //         sort: true,
        //         search: true,
        //         data: [
        //             ["01", "Jonathan", "jonathan@example.com", "07067317819", "Hauck Inc", "completed"],
        //             ["02", "Harold", "harold@example.com", "07067317819", "Metz Inc", "pending"],
        //             ["03", "Shannon", "shannon@example.com", "07067317819", "Zemlak Group", "active"],
        //             ["04", "Robert", "robert@example.com", "07067317819", "Hoeger", "pending"],
        //             ["05", "Noel", "noel@example.com", "07067317819", "Howell - Rippin", "completed"],
        //             ["06", "Traci", "traci@example.com", "07067317819", "Koelpin - Goldner", "completed"],
        //             ["07", "Kerry", "kerry@example.com", "07067317819", "Feeney, Langworth and Tremblay", "active"],
        //             ["08", "Patsy", "patsy@example.com", "07067317819", "Streich Group", "Ongoing"],
        //             ["09", "Cathy", "cathy@example.com", "07067317819", "Ebert, Schamberger and Johnston", "pending"],
        //             ["10", "Tyrone", "tyrone@example.com", "07067317819", "Raynor, Rolfson and Daugherty", "active"],
        //         ]
        //     }).render(document.getElementById("table-gridjs"));

        // }
        


        
            

            //Customer list Table
            if (document.getElementById("table-manage-customers"))
            new gridjs.Grid({
                columns: [{
                    name: 'ID',
                    formatter: (function (cell) {
                        return gridjs.html('<span class="fw-semibold">' + cell + '</span>');
                    })
                },
                    "Name",
                {
                    name: 'Email',
                    formatter: (function (cell) {
                        return gridjs.html('<a href="">' + cell + '</a>');
                    })
                },
                    "Phone Number", "Company",
                    {
                        name: 'Status',
                        formatter: function (cell) {
                            let bgClass = '';
                            let textClass = '';
                    
                            switch (cell.toLowerCase()) {
                                case 'open':
                                    bgClass = 'bg-primary-subtle';
                                    textClass = 'text-primary';
                                    break;
                                case 'active':
                                    bgClass = 'bg-success-subtle';
                                    textClass = 'text-success';
                                    break;
                                case 'pending':
                                    bgClass = 'bg-warning-subtle';
                                    textClass = 'text-warning';
                                    break;
                                case 'rejected':
                                    bgClass = 'bg-warning-subtle';
                                    textClass = 'text-danger';
                                    break;
                                    case 'completed':
                                    bgClass = 'bg-success-subtle';
                                    textClass = 'text-success';
                                default:
                                    bgClass = 'bg-secondary-subtle';
                                    textClass = 'text-secondary';
                            }
                    
                            return gridjs.html(
                                `<span class="badge ${bgClass} ${textClass}">${cell}</span>`
                            );
                        }
                    },
                {
                    name: 'Actions',
                    width: '120px',
                    formatter: (function (cell) {
                        return gridjs.html("<a href='#' class='text-reset text-decoration-underline'>" + "<a href='edit' class='me-0.5'> <i class='mgc_edit_line text-lg'></i> </a> " + " <a href='javascript:void(0);' class='ms-0.5'> <i class='mgc_delete_line text-xl'></i> </a>"  + " <a href='javascript:void(0);' class='ms-0.5'> <i class='mgc_view_line text-xl'></i> </a>" + "</a>");
                    })
                },
                ],
                pagination: {
                    limit: 5
                },
                sort: true,
                search: true,
                data: [
                    ["01", "Jonathan", "jonathan@example.com", "07067317819", "Hauck Inc", "completed"],
                    ["02", "Harold", "harold@example.com", "07067317819", "Metz Inc", "pending"],
                    ["03", "Shannon", "shannon@example.com", "07067317819", "Zemlak Group", "active"],
                    ["04", "Robert", "robert@example.com", "07067317819", "Hoeger", "pending"],
                    ["05", "Noel", "noel@example.com", "07067317819", "Howell - Rippin", "completed"],
                    ["06", "Traci", "traci@example.com", "07067317819", "Koelpin - Goldner", "completed"],
                    ["07", "Kerry", "kerry@example.com", "07067317819", "Feeney, Langworth and Tremblay", "active"],
                    ["08", "Patsy", "patsy@example.com", "07067317819", "Streich Group", "Ongoing"],
                    ["09", "Cathy", "cathy@example.com", "07067317819", "Ebert, Schamberger and Johnston", "pending"],
                    ["10", "Tyrone", "tyrone@example.com", "07067317819", "Raynor, Rolfson and Daugherty", "active"],
                ]
            }).render(document.getElementById("table-manage-customers"));

            // Customers Feedback Table
       // Manage Roles with Current and Addable Roles
if (document.getElementById("table-manageRoles")) {
    // Define all possible roles from your system
    const allRoles = [
        { value: 'customer', label: 'Customer' },
        { value: 'support', label: 'Support' },
        { value: 'admin', label: 'Admin' },
        { value: 'qualitycontrol', label: 'QA' },
        { value: 'supervisor', label: 'Supervisor' },
        { value: 'account', label: 'Account' },
        { value: 'businessdeveloper', label: 'Business Developer' },
        { value: 'businessmanager', label: 'Business Manager' },
        { value: 'businesssupervisor', label: 'Business Supervisor' },
        { value: 'customermanager', label: 'Customer Manager' }
    ];

    // Function to fetch user data
    const fetchUsers = async () => {
        try {
            const response = await fetch('/dashboard/users/manage');
            console.log('Fetch users response:', response);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            console.log('Fetched users data:', data);
            
            // Transform data to match what we need for the grid
            return data.map(user => ({
                id: user.id,
                name: user.name,
                email: user.email,
                current_roles: [user.role.toLowerCase()], // Array of current roles
                status: user.status === 1 ? 'active' : 'inactive',
                role_data: user.role_data,
                user_type: user.user_type
            }));
            
        } catch (error) {
            console.error('Error fetching users:', error);
            return [];
        }
    };

    // Initialize the grid
    const userGrid = new gridjs.Grid({
        columns: [
            {
                name: 'ID',
                formatter: (cell) => gridjs.html(`<span class="font-semibold">${cell}</span>`),
                width: '80px'
            },
            {
                name: 'Full Name',
                formatter: (cell) => gridjs.html(`<span class="font-medium">${cell}</span>`)
            },
            {
                name: 'Email',
                formatter: (cell) => gridjs.html(`<a href="mailto:${cell}" class="text-primary hover:underline">${cell}</a>`)
            },
            {
                name: 'Current Roles',
                formatter: (cell, row) => {
                    return gridjs.html(`
                        <div class="flex flex-wrap gap-1">
                            ${cell.map(role => {
                                const roleInfo = allRoles.find(r => r.value === role);
                                return `<span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-800">${roleInfo?.label || role}</span>`;
                            }).join('')}
                        </div>
                    `);
                }
            },
            {
                name: 'Add Role',
                formatter: (cell, row) => {
                    const currentRoles = row.cells[3].data; // Current roles from hidden column
                    const availableRoles = allRoles.filter(role => !currentRoles.includes(role.value));
                    
                    return gridjs.html(`
                        <div class="flex items-center gap-2">
                            <select class="add-role-select form-select form-select-sm" 
                                    data-user-id="${row.cells[0].data}">
                                <option value="">Select role to add</option>
                                ${availableRoles.map(role => `
                                    <option value="${role.value}">${role.label}</option>
                                `).join('')}
                            </select>
                            <button class="btn-add-role p-1 rounded text-success hover:bg-success/10" 
                                    data-user-id="${row.cells[0].data}">
                                <i class="ti ti-plus text-lg"></i>
                            </button>
                        </div>
                    `);
                }
            },
            {
                name: 'Status',
                formatter: (cell) => {
                    const isActive = cell === 'active';
                    const bgClass = isActive ? 'bg-success-subtle' : 'bg-danger-subtle';
                    const textClass = isActive ? 'text-success' : 'text-danger';
                    const statusText = isActive ? 'Active' : 'Inactive';
                    
                    return gridjs.html(
                        `<span class="px-2 py-1 rounded-md ${bgClass} ${textClass}">${statusText}</span>`
                    );
                }
            },
            {
                name: 'Actions',
                width: '120px',
                formatter: (cell, row) => {
                    const userId = row.cells[0].data;
                    return gridjs.html(`
                        <div class="flex gap-2">
                            <button class="btn-view p-1 rounded text-primary hover:bg-primary/10" 
                                    data-user-id="${userId}">
                                <i class="ti ti-eye text-lg"></i>
                            </button>
                            <button class="btn-edit p-1 rounded text-warning hover:bg-warning/10" 
                                    data-user-id="${userId}">
                                <i class="ti ti-edit text-lg"></i>
                            </button>
                            <button class="btn-delete p-1 rounded text-danger hover:bg-danger/10" 
                                    data-user-id="${userId}">
                                <i class="ti ti-trash text-lg"></i>
                            </button>
                        </div>
                    `);
                }
            },
            // Hidden columns for internal data
            {
                name: 'current_roles',
                hidden: true
            },
            {
                name: 'role_data',
                hidden: true
            },
            {
                name: 'user_type',
                hidden: true
            }
        ],
        pagination: {
            limit: 10
        },
        sort: true,
        search: true,
        data: () => fetchUsers().then(data => data.map(user => [
            user.id,
            user.name,
            user.email,
            user.current_roles, // Current roles (array)
            '', // Add role controls
            user.status,
            '', // Actions
            user.current_roles, // Hidden current roles
            user.role_data,
            user.role
        ])),
        language: {
            search: {
                placeholder: 'Search users...'
            },
            pagination: {
                previous: '←',
                next: '→',
                showing: 'Showing',
                results: () => 'Records'
            }
        }
    }).render(document.getElementById("table-manageRoles"));

    // Add event listeners after render
    userGrid.on('render', () => {
        // Add role button handler
        document.querySelectorAll('.btn-add-role').forEach(btn => {
            btn.addEventListener('click', async function() {
                const userId = this.dataset.userId;
                const select = this.previousElementSibling;
                const newRole = select.value;
                
                if (!newRole) {
                    showNotification('Please select a role to add', 'warning');
                    return;
                }
                
                try {
                    console.log(`Attempting to add role ${newRole} to user ${userId}`);
                    const response = await fetch(`/api/users/${userId}/add-role`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ role: newRole })
                    });
                    
                    const responseData = await response.json();
                    console.log('Add role response:', response, responseData);
                    
                    if (response.ok) {
                        showNotification('Role added successfully', 'success');
                        // Reset the select
                        select.value = '';
                        // Refresh the grid
                        userGrid.forceRender();
                    } else {
                        throw new Error(responseData.message || 'Failed to add role');
                    }
                } catch (error) {
                    console.error('Error adding role:', error);
                    showNotification(error.message || 'Error adding role', 'error');
                }
            });
        });

        // View button handler
        document.querySelectorAll('.btn-view').forEach(btn => {
            btn.addEventListener('click', () => {
                const userId = btn.dataset.userId;
                window.location.href = `/users/${userId}`;
            });
        });

        // Edit button handler
        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', () => {
                const userId = btn.dataset.userId;
                window.location.href = `/users/${userId}/edit`;
            });
        });

        // Delete button handler
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', async () => {
                const userId = btn.dataset.userId;
                if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
                    try {
                        console.log(`Attempting to delete user ${userId}`);
                        const response = await fetch(`/api/users/${userId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        });
                        
                        const responseData = await response.json();
                        console.log('Delete response:', response, responseData);
                        
                        if (response.ok) {
                            showNotification('User deleted successfully', 'success');
                            userGrid.forceRender();
                        } else {
                            throw new Error(responseData.message || 'Failed to delete user');
                        }
                    } catch (error) {
                        console.error('Error deleting user:', error);
                        showNotification(error.message || 'Error deleting user', 'error');
                    }
                }
            });
        });
    });

    // Helper function for showing notifications
    function showNotification(message, type = 'success') {
        const alertClass = type === 'success' ? 'alert-success' : 
                         type === 'error' ? 'alert-danger' : 'alert-warning';
        const icon = type === 'success' ? 'circle-check' : 
                    type === 'error' ? 'alert-circle' : 'alert-triangle';
        
        const alertBox = document.createElement('div');
        alertBox.className = `alert ${alertClass} fixed top-4 right-4 z-50`;
        alertBox.innerHTML = `
            <div class="flex items-start gap-3">
                <i class="ti ti-${icon} text-lg"></i>
                <div>${message}</div>
            </div>
        `;
        document.body.appendChild(alertBox);
        
        setTimeout(() => {
            alertBox.classList.add('opacity-0', 'transition-opacity', 'duration-300');
            setTimeout(() => alertBox.remove(), 300);
        }, 3000);
    }
}

        // card Table
        if (document.getElementById("table-card"))
            new gridjs.Grid({
                columns: ["Name", "Email", "Position", "Company", "Country"],
                sort: true,
                pagination: {
                    limit: 5
                },
                data: [
                    ["Jonathan", "jonathan@example.com", "Senior Implementation Architect", "Hauck Inc", "Holy See"],
                    ["Harold", "harold@example.com", "Forward Creative Coordinator", "Metz Inc", "Iran"],
                    ["Shannon", "shannon@example.com", "Legacy Functionality Associate", "Zemlak Group", "South Georgia"],
                    ["Robert", "robert@example.com", "Product Accounts Technician", "Hoeger", "San Marino"],
                    ["Noel", "noel@example.com", "Customer Data Director", "Howell - Rippin", "Germany"],
                    ["Traci", "traci@example.com", "Corporate Identity Director", "Koelpin - Goldner", "Vanuatu"],
                    ["Kerry", "kerry@example.com", "Lead Applications Associate", "Feeney, Langworth and Tremblay", "Niger"],
                    ["Patsy", "patsy@example.com", "Dynamic Assurance Director", "Streich Group", "Niue"],
                    ["Cathy", "cathy@example.com", "Customer Data Director", "Ebert, Schamberger and Johnston", "Mexico"],
                    ["Tyrone", "tyrone@example.com", "Senior Response Liaison", "Raynor, Rolfson and Daugherty", "Qatar"],
                ]
            }).render(document.getElementById("table-card"));


        // pagination Table
        if (document.getElementById("table-pagination"))
            new gridjs.Grid({
                columns: [{
                    name: 'ID',
                    width: '120px',
                    formatter: (function (cell) {
                        return gridjs.html('<a href="" class="fw-medium">' + cell + '</a>');
                    })
                }, "Name", "Date", "Total", "Status",
                {
                    name: 'Actions',
                    width: '100px',
                    formatter: (function (cell) {
                        return gridjs.html("<button type='button' class='btn btn-sm btn-light'>" +
                            "Details" +
                            "</button>");
                    })
                },
                ],
                pagination: {
                    limit: 5
                },

                data: [
                    ["#VL2111", "Jonathan", "07 Oct, 2021", "$24.05", "Paid",],
                    ["#VL2110", "Harold", "07 Oct, 2021", "$26.15", "Paid"],
                    ["#VL2109", "Shannon", "06 Oct, 2021", "$21.25", "Refund"],
                    ["#VL2108", "Robert", "05 Oct, 2021", "$25.03", "Paid"],
                    ["#VL2107", "Noel", "05 Oct, 2021", "$22.61", "Paid"],
                    ["#VL2106", "Traci", "04 Oct, 2021", "$24.05", "Paid"],
                    ["#VL2105", "Kerry", "04 Oct, 2021", "$26.15", "Paid"],
                    ["#VL2104", "Patsy", "04 Oct, 2021", "$21.25", "Refund"],
                    ["#VL2103", "Cathy", "03 Oct, 2021", "$22.61", "Paid"],
                    ["#VL2102", "Tyrone", "03 Oct, 2021", "$25.03", "Paid"],
                ]
            }).render(document.getElementById("table-pagination"));

        // search Table
        if (document.getElementById("table-search"))
            new gridjs.Grid({
                columns: ["Name", "Email", "Position", "Company", "Country"],
                pagination: {
                    limit: 5
                },
                search: true,
                data: [
                    ["Jonathan", "jonathan@example.com", "Senior Implementation Architect", "Hauck Inc", "Holy See"],
                    ["Harold", "harold@example.com", "Forward Creative Coordinator", "Metz Inc", "Iran"],
                    ["Shannon", "shannon@example.com", "Legacy Functionality Associate", "Zemlak Group", "South Georgia"],
                    ["Robert", "robert@example.com", "Product Accounts Technician", "Hoeger", "San Marino"],
                    ["Noel", "noel@example.com", "Customer Data Director", "Howell - Rippin", "Germany"],
                    ["Traci", "traci@example.com", "Corporate Identity Director", "Koelpin - Goldner", "Vanuatu"],
                    ["Kerry", "kerry@example.com", "Lead Applications Associate", "Feeney, Langworth and Tremblay", "Niger"],
                    ["Patsy", "patsy@example.com", "Dynamic Assurance Director", "Streich Group", "Niue"],
                    ["Cathy", "cathy@example.com", "Customer Data Director", "Ebert, Schamberger and Johnston", "Mexico"],
                    ["Tyrone", "tyrone@example.com", "Senior Response Liaison", "Raynor, Rolfson and Daugherty", "Qatar"],
                ]
            }).render(document.getElementById("table-search"));

        // Sorting Table
        if (document.getElementById("table-sorting"))
            new gridjs.Grid({
                columns: ["Name", "Email", "Position", "Company", "Country"],
                pagination: {
                    limit: 5
                },
                sort: true,
                data: [
                    ["Jonathan", "jonathan@example.com", "Senior Implementation Architect", "Hauck Inc", "Holy See"],
                    ["Harold", "harold@example.com", "Forward Creative Coordinator", "Metz Inc", "Iran"],
                    ["Shannon", "shannon@example.com", "Legacy Functionality Associate", "Zemlak Group", "South Georgia"],
                    ["Robert", "robert@example.com", "Product Accounts Technician", "Hoeger", "San Marino"],
                    ["Noel", "noel@example.com", "Customer Data Director", "Howell - Rippin", "Germany"],
                    ["Traci", "traci@example.com", "Corporate Identity Director", "Koelpin - Goldner", "Vanuatu"],
                    ["Kerry", "kerry@example.com", "Lead Applications Associate", "Feeney, Langworth and Tremblay", "Niger"],
                    ["Patsy", "patsy@example.com", "Dynamic Assurance Director", "Streich Group", "Niue"],
                    ["Cathy", "cathy@example.com", "Customer Data Director", "Ebert, Schamberger and Johnston", "Mexico"],
                    ["Tyrone", "tyrone@example.com", "Senior Response Liaison", "Raynor, Rolfson and Daugherty", "Qatar"],
                ]
            }).render(document.getElementById("table-sorting"));


        // Loading State Table
        if (document.getElementById("table-loading-state"))
            new gridjs.Grid({
                columns: ["Name", "Email", "Position", "Company", "Country"],
                pagination: {
                    limit: 5
                },
                sort: true,
                data: function () {
                    return new Promise(function (resolve) {
                        setTimeout(function () {
                            resolve([
                                ["Jonathan", "jonathan@example.com", "Senior Implementation Architect", "Hauck Inc", "Holy See"],
                                ["Harold", "harold@example.com", "Forward Creative Coordinator", "Metz Inc", "Iran"],
                                ["Shannon", "shannon@example.com", "Legacy Functionality Associate", "Zemlak Group", "South Georgia"],
                                ["Robert", "robert@example.com", "Product Accounts Technician", "Hoeger", "San Marino"],
                                ["Noel", "noel@example.com", "Customer Data Director", "Howell - Rippin", "Germany"],
                                ["Traci", "traci@example.com", "Corporate Identity Director", "Koelpin - Goldner", "Vanuatu"],
                                ["Kerry", "kerry@example.com", "Lead Applications Associate", "Feeney, Langworth and Tremblay", "Niger"],
                                ["Patsy", "patsy@example.com", "Dynamic Assurance Director", "Streich Group", "Niue"],
                                ["Cathy", "cathy@example.com", "Customer Data Director", "Ebert, Schamberger and Johnston", "Mexico"],
                                ["Tyrone", "tyrone@example.com", "Senior Response Liaison", "Raynor, Rolfson and Daugherty", "Qatar"]
                            ])
                        }, 2000);
                    });
                }
            }).render(document.getElementById("table-loading-state"));


        // Fixed Header
        if (document.getElementById("table-fixed-header"))
            new gridjs.Grid({
                columns: ["Name", "Email", "Position", "Company", "Country"],
                sort: true,
                pagination: true,
                fixedHeader: true,
                height: '400px',
                data: [
                    ["Jonathan", "jonathan@example.com", "Senior Implementation Architect", "Hauck Inc", "Holy See"],
                    ["Harold", "harold@example.com", "Forward Creative Coordinator", "Metz Inc", "Iran"],
                    ["Shannon", "shannon@example.com", "Legacy Functionality Associate", "Zemlak Group", "South Georgia"],
                    ["Robert", "robert@example.com", "Product Accounts Technician", "Hoeger", "San Marino"],
                    ["Noel", "noel@example.com", "Customer Data Director", "Howell - Rippin", "Germany"],
                    ["Traci", "traci@example.com", "Corporate Identity Director", "Koelpin - Goldner", "Vanuatu"],
                    ["Kerry", "kerry@example.com", "Lead Applications Associate", "Feeney, Langworth and Tremblay", "Niger"],
                    ["Patsy", "patsy@example.com", "Dynamic Assurance Director", "Streich Group", "Niue"],
                    ["Cathy", "cathy@example.com", "Customer Data Director", "Ebert, Schamberger and Johnston", "Mexico"],
                    ["Tyrone", "tyrone@example.com", "Senior Response Liaison", "Raynor, Rolfson and Daugherty", "Qatar"],
                ]
            }).render(document.getElementById("table-fixed-header"));


        // Hidden Columns
        if (document.getElementById("table-hidden-column"))
            new gridjs.Grid({
                columns: ["Name", "Email", "Position", "Company",
                    {
                        name: 'Country',
                        hidden: true
                    },
                ],
                pagination: {
                    limit: 5
                },
                sort: true,
                data: [
                    ["Jonathan", "jonathan@example.com", "Senior Implementation Architect", "Hauck Inc", "Holy See"],
                    ["Harold", "harold@example.com", "Forward Creative Coordinator", "Metz Inc", "Iran"],
                    ["Shannon", "shannon@example.com", "Legacy Functionality Associate", "Zemlak Group", "South Georgia"],
                    ["Robert", "robert@example.com", "Product Accounts Technician", "Hoeger", "San Marino"],
                    ["Noel", "noel@example.com", "Customer Data Director", "Howell - Rippin", "Germany"],
                    ["Traci", "traci@example.com", "Corporate Identity Director", "Koelpin - Goldner", "Vanuatu"],
                    ["Kerry", "kerry@example.com", "Lead Applications Associate", "Feeney, Langworth and Tremblay", "Niger"],
                    ["Patsy", "patsy@example.com", "Dynamic Assurance Director", "Streich Group", "Niue"],
                    ["Cathy", "cathy@example.com", "Customer Data Director", "Ebert, Schamberger and Johnston", "Mexico"],
                    ["Tyrone", "tyrone@example.com", "Senior Response Liaison", "Raynor, Rolfson and Daugherty", "Qatar"],
                ]
            }).render(document.getElementById("table-hidden-column"));


    }

}

document.addEventListener('DOMContentLoaded', function (e) {
    new GridDatatable().init();
});


