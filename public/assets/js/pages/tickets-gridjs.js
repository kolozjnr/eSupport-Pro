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

           


        // Tickets Table - Customers
        async function initializeCustomerTicketsTable() {
  const tableContainer = document.getElementById("customer-tickets-table");
  const loadingIndicator = document.getElementById("loading-indicator");
  
  try {
    // Show loading indicator
    if (loadingIndicator) loadingIndicator.classList.remove('hidden');
    if (tableContainer) tableContainer.innerHTML = '';
    
    // Fetch tickets from your Laravel endpoint
    const response = await fetch('/dashboard/tickets/customer-tickets', {
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
            name: 'ID',
            formatter: (cell) => gridjs.html(`<span class="fw-semibold">${cell}</span>`),
            sort: true,
            hidden: true
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
                formatter: (cell) => {
                    const maxLength = 35;
                    const text = cell || 'N/A';
                    const truncated = text.length > maxLength 
                        ? text.substring(0, maxLength) + '...' 
                        : text;
                    return gridjs.html(`<span title="${text}">${truncated}</span>`);
                },
                sort: true,
                width: 200
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
            name: 'File',
            hidden: true
          },
          {
            name: 'Actions',
            width: '180px',
            formatter: (cell, row) => {
              const ticketId = row.cells[1].data;
              const status = row.cells[5].data?.toLowerCase();
              const file = row.cells[7].data;
              const supportData = row.cells[2].data;
              const assignedTo = supportData && supportData.user && supportData.user.id 
              ? supportData.user 
              : null;
              
              // Base actions (edit, delete, view)
              let actionsHTML = `
                <div class="flex items-center">
                  <a href="/dashboard/tickets/${ticketId}/edit-ticket" class="text-warning me-2" title="Edit">
                    <i class="mgc_edit_line text-lg"></i>
                  </a>
                  <a href="/dashboard/tickets/view-single-ticket/${ticketId}" class="text-primary me-2" title="View">
                        <i class="mgc_eye_2_line text-xl"></i>
                    </a>

                  <a href="javascript:void(0);" onclick="deleteTicket('${ticketId}')" class="text-danger me-2" title="Delete">
                    <i class="mgc_delete_line text-xl"></i>
                  </a>
              `;
              if(assignedTo){
                actionsHTML += `
                  <a href="/dashboard/chat/ticket/${ticketId}" class="text-primary me-2" title="Chat">
                    <i class="mgc_chat_2_line text-xl"></i>
                  </a>
                  
                `
              }
                  if (file) {
                actionsHTML += `
                    <a href="${file}" target="_blank" class="text-info me-2" title="View Attachment">
                    <i class="mgc_attachment_2_line text-xl"></i>
                    </a>
                `;
                }
              
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
        data: tickets.map((ticket, index) => [
          index + 1,
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
          ticket.attached?.[0]?.file || '',
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
                        formatter: (cell) => {
                            const maxLength = 35;
                            const text = cell || 'N/A';
                            const truncated = text.length > maxLength 
                                ? text.substring(0, maxLength) + '...' 
                                : text;
                            return gridjs.html(`<span title="${text}">${truncated}</span>`);
                        },
                        sort: true,
                        width: '200px'
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
                        
                        //selectedTickets+ticketId;
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

  async function initializeSupervisorTicketsTable() {
    const tableContainer = document.getElementById("supervisor-tickets");
    const loadingIndicator = document.getElementById("loading-indicator");
    const bulkActionBtn = document.getElementById("bulk-action-btn");;
    
    try {
        // Show loading indicator
        if (loadingIndicator) loadingIndicator.classList.remove('hidden');
        if (tableContainer) tableContainer.innerHTML = '';
        
        // Hide bulk action button initially
        if (bulkActionBtn) bulkActionBtn.classList.add('hidden');
        
        // Fetch tickets from your Laravel endpoint
        const response = await fetch('/dashboard/tickets/supervisor-tickets', {
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('auth_token')
            }
        });
        
        if (!response.ok) {
            throw new Error('Failed to fetch tickets: ' + response.statusText);
        }
        
        const tickets = await response.json();
        console.log('Supervisorr Tickets data:', tickets);
        
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
                        id: 'id',
                        name: '#',
                        formatter: (cell) => gridjs.html(`<span class="fw-semibold">${cell}</span>`),
                        sort: true,
                        width: '80px'
                    },
                    {
                        name: 'Description',
                        formatter: (cell) => {
                            const maxLength = 35;
                            const text = cell || 'N/A';
                            const truncated = text.length > maxLength 
                                ? text.substring(0, maxLength) + '...' 
                                : text;
                            return gridjs.html(`<span title="${text}">${truncated}</span>`);
                        },
                        sort: true,
                        width: '200px'
                    },
                    {
                        id: 'customer_name',
                        name: 'Customer Name',
                        formatter: (cell) => {
                            const userName = cell?.user?.fname + ' ' + cell?.user?.lname || cell?.fname || 'N/A';
                            return gridjs.html(`<span>${userName}</span>`);
                        }
                    },
                    {
                        id: 'review_comment',
                        name: 'Review Comment',
                        formatter: (cell) => {
                            if (!cell || cell.length === 0) return 'N/A';
                            const comment = cell[0]?.comment || 'No comment';
                            return gridjs.html(`<span class="text-muted">${comment}</span>`);
                        }
                    },
                    {
                        id: 'rating',
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
                        id: 'assigned_to',
                        name: 'Assigned To',
                        formatter: (cell) => {
                            // Safely get the user name with multiple fallbacks
                            let userName = 'N/A';
                            
                            if (cell?.user) {
                                userName = [cell.user.fname, cell.user.lname]
                                    .filter(Boolean) // Remove null/undefined values
                                    .join(' ')
                                    .trim() || 'N/A';
                            } else if (cell?.fname) {
                                userName = [cell.fname, cell.lname]
                                    .filter(Boolean)
                                    .join(' ')
                                    .trim() || cell.fname || 'N/A';
                            } else if (cell?.name) {
                                userName = cell.name || 'N/A';
                            }
                            
                            return gridjs.html(`<span>${userName}</span>`);
                        }
                    },
                    // {
                    //     id: 'assigned_to',
                    //     name: 'Assigned To',
                    //     formatter: (cell) => {
                    //         const userName = cell?.user?.fname + ' ' + cell?.user?.lname || cell?.fname || 'N/A';
                    //         return gridjs.html(`<span>${userName}</span>`);
                    //     }
                    // },
                    {
                        id: 'status',
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
                        id: 'created_at',
                        name: 'Created At',
                        formatter: (cell) => cell ? new Date(cell).toLocaleDateString() : 'N/A',
                        sort: true
                    },
                    {
                        id: 'action',
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
                        id: 'check_box',
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

            window.grid = grid;
            
            // Add event listener for checkboxes
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('ticket-checkbox')) {
                    const ticketId = e.target.dataset.id;
                    if (e.target.checked) {
                        //selectedTickets.add(ticketId);
                        selectedTickets+ticketId;
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
            exportGridToCSV(grid);
            });

            document.querySelector('.export-pdf').addEventListener('click', () => {
            exportGridToPDF(grid);
            });
        }
    } catch (error) {
        console.error('Error initializing tickets table:', error);
        if (tableContainer) {
            tableContainer.innerHTML = `
                <div class="alert alert-danger p-4">
                    <h4 class="alert-heading">Failed to load tickets</h4>
                    <p>${error.message}</p>
                    <button onclick="initializeSupervisorTicketsTable()" class="btn btn-sm btn-primary mt-2">
                        Retry
                    </button>
                </div>
            `;
        }
    } finally {
        if (loadingIndicator) loadingIndicator.classList.add('hidden');
    }
}

// Global cleaner
window.cleanCellValue = function (value) {
    if (!value) return ""; // blank if null/undefined/empty
    if (typeof value === "object") return ""; // prevent [object Object]
    return String(value);
};

// Helper to get today's date in YYYY-MM-DD
window.getCurrentDateString = function() {
    const now = new Date();
    const yyyy = now.getFullYear();
    const mm = String(now.getMonth() + 1).padStart(2, "0");
    const dd = String(now.getDate()).padStart(2, "0");
    return `${yyyy}-${mm}-${dd}`;
}


// Export CSV
window.exportGridToCSV = async function (grid) {
    const data = await grid.config.data;
    const headers = grid.config.columns.map(col => col.name).join(",");

    const csv = data.map(row =>
        row.map(cell => `"${window.cleanCellValue(cell)}"`).join(",")
    );
    const csvContent = [headers].concat(csv).join("\n");

    const blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });
    const url = URL.createObjectURL(blob);
    const link = document.createElement("a");
    link.href = url;
    link.download = `grid_export_${getCurrentDateString()}.csv`;
    link.click();
};

// Export PDF
window.exportGridToPDF = async function (grid) {
    const data = await grid.config.data;
    const headers = grid.config.columns.map(col => col.name);

    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    doc.autoTable({
        head: [headers],
        body: data.map(row => row.map(cell => window.cleanCellValue(cell)))
    });
    doc.save(`grid_export_${getCurrentDateString()}.pdf`);
};

// Export Excel
window.exportGridToExcel = async function (grid) {
    const data = await grid.config.data;
    const headers = grid.config.columns.map(col => col.name);

    const worksheet = XLSX.utils.aoa_to_sheet([
        headers,
        ...data.map(row => row.map(cell => window.cleanCellValue(cell)))
    ]);
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, "Grid Data");
    XLSX.writeFile(workbook, `grid_export_${getCurrentDateString()}.xlsx`);
};




//Get Ticket poll for Support Staffs
async function initializeTicketsPollTable() {
    const tableContainer = document.getElementById("ticket-polls");
    const loadingIndicator = document.getElementById("loading-indicator");
    const bulkActionBtn = document.getElementById("bulk-action-btn");;
    
    try {
        // Show loading indicator
        if (loadingIndicator) loadingIndicator.classList.remove('hidden');
        if (tableContainer) tableContainer.innerHTML = '';
        
        // Hide bulk action button initially
        if (bulkActionBtn) bulkActionBtn.classList.add('hidden');
        
        // Fetch tickets from your Laravel endpoint
        const response = await fetch('/dashboard/tickets/get-tickets-poll', {
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('auth_token')
            }
        });
        
        if (!response.ok) {
            throw new Error('Failed to fetch tickets: ' + response.statusText);
        }
        
        const tickets = await response.json();
        console.log('poll Tickets data:', tickets);
        
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
                        id: 'id',
                        name: '#',
                        formatter: (cell) => gridjs.html(`<span class="fw-semibold">${cell}</span>`),
                        sort: true,
                        width: '80px'
                    },
                    {
                        name: 'Description',
                        formatter: (cell) => {
                            const maxLength = 35;
                            const text = cell || 'N/A';
                            const truncated = text.length > maxLength 
                                ? text.substring(0, maxLength) + '...' 
                                : text;
                            return gridjs.html(`<span title="${text}">${truncated}</span>`);
                        },
                        sort: true,
                        width: '200px'
                    },
                    {
                        id: 'customer_name',
                        name: 'Customer Name',
                        formatter: (cell) => {
                            const userName = cell?.user?.fname + ' ' + cell?.user?.lname || cell?.fname || 'N/A';
                            return gridjs.html(`<span>${userName}</span>`);
                        }
                    },
                    {
                        id: 'review_comment',
                        name: 'Review Comment',
                        formatter: (cell) => {
                            if (!cell || cell.length === 0) return 'N/A';
                            const comment = cell[0]?.comment || 'No comment';
                            return gridjs.html(`<span class="text-muted">${comment}</span>`);
                        }
                    },
                    {
                        id: 'rating',
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
                        id: 'assigned_to',
                        name: 'Assigned To',
                        formatter: (cell) => {
                            // Safely get the user name with multiple fallbacks
                            let userName = 'N/A';
                            
                            if (cell?.user) {
                                userName = [cell.user.fname, cell.user.lname]
                                    .filter(Boolean) // Remove null/undefined values
                                    .join(' ')
                                    .trim() || 'N/A';
                            } else if (cell?.fname) {
                                userName = [cell.fname, cell.lname]
                                    .filter(Boolean)
                                    .join(' ')
                                    .trim() || cell.fname || 'N/A';
                            } else if (cell?.name) {
                                userName = cell.name || 'N/A';
                            }
                            
                            return gridjs.html(`<span>${userName}</span>`);
                        }
                    },
                    {
                        id: 'status',
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
                        id: 'created_at',
                        name: 'Created At',
                        formatter: (cell) => cell ? new Date(cell).toLocaleDateString() : 'N/A',
                        sort: true
                    },
                    {
                        id: 'action',
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
                        id: 'check_box',
                        name: '',
                        width: '40px',
                        formatter: (cell, row) => {
                            const ticketId = row.cells[9].data; // First column has the ID
                            const status = row.cells[6].data?.toLowerCase();
                            if (status === 'open' || status === 'rejected') {
                            return gridjs.html(`
                                <input type="checkbox" 
                                    class="ticket-checkboxP" 
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
                    ticket.support?.fname || 'N/A',
                    ticket.status || 'N/A',
                    ticket.created_at || 'N/A',
                    '', // Actions column
                     ticket.id, // First column - ID (used in checkbox)
                     ticket.id, // Second column - hidden ID
                ])
            }).render(tableContainer);
            
            // Add event listener for checkboxes
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('ticket-checkboxP')) {
                    const ticketId = e.target.dataset.id;
                    if (e.target.checked) {
                        selectedTickets+ticketId;
                        //this was a shit idea, courtesy Barnabas
                        //selectedTickets.add(ticketId);
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
                </button><button id="bulk-action-btn" class="btn btn-outline-success btn-sm hidden" 
                        onclick="submitBulkUpdatePoll()">
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
                    <button onclick="initializeTicketsPollTable()" class="btn btn-sm btn-primary mt-2">
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
        initializeSupervisorTicketsTable(); // Refresh the table
        
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
        const response = await fetch('/dashboard/tickets/support-tickets', {
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
                        formatter: (cell) => {
                            const maxLength = 35;
                            const text = cell || 'N/A';
                            const truncated = text.length > maxLength 
                                ? text.substring(0, maxLength) + '...' 
                                : text;
                            return gridjs.html(`<span title="${text}">${truncated}</span>`);
                        },
                        sort: true,
                        width: '200px'
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

                                     <a href="/dashboard/chat/ticket/${ticketId}" class="text-primary me-2" title="Chat">
                                        <i class="mgc_chat_2_line text-xl"></i>
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

            window.grid = grid;
            
            // Rest of your code (event listeners, export buttons, etc.)
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('ticket-checkbox')) {
                    const ticketId = e.target.dataset.id;
                    if (e.target.checked) {
                        //selectedTickets.add(ticketId);
                        selectedTickets+ticketId;
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
            exportGridToCSV(grid);
            });

            document.querySelector('.export-pdf').addEventListener('click', () => {
            exportGridToPDF(grid);
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

    // // Global cleaner
window.cleanCellValue = function (value) {
    if (!value) return ""; // blank if null/undefined/empty
    if (typeof value === "object") return ""; // prevent [object Object]
    return String(value);
};

// Helper to get today's date in YYYY-MM-DD
window.getCurrentDateString = function() {
    const now = new Date();
    const yyyy = now.getFullYear();
    const mm = String(now.getMonth() + 1).padStart(2, "0");
    const dd = String(now.getDate()).padStart(2, "0");
    return `${yyyy}-${mm}-${dd}`;
}


// Export CSV
window.exportGridToCSV = async function (grid) {
    const data = await grid.config.data;
    const headers = grid.config.columns.map(col => col.name).join(",");

    const csv = data.map(row =>
        row.map(cell => `"${window.cleanCellValue(cell)}"`).join(",")
    );
    const csvContent = [headers].concat(csv).join("\n");

    const blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });
    const url = URL.createObjectURL(blob);
    const link = document.createElement("a");
    link.href = url;
    link.download = `grid_export_${getCurrentDateString()}.csv`;
    link.click();
};

// Export PDF
window.exportGridToPDF = async function (grid) {
    const data = await grid.config.data;
    const headers = grid.config.columns.map(col => col.name);

    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    doc.autoTable({
        head: [headers],
        body: data.map(row => row.map(cell => window.cleanCellValue(cell)))
    });
    doc.save(`grid_export_${getCurrentDateString()}.pdf`);
};

// Export Excel
window.exportGridToExcel = async function (grid) {
    const data = await grid.config.data;
    const headers = grid.config.columns.map(col => col.name);

    const worksheet = XLSX.utils.aoa_to_sheet([
        headers,
        ...data.map(row => row.map(cell => window.cleanCellValue(cell)))
    ]);
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, "Grid Data");
    XLSX.writeFile(workbook, `grid_export_${getCurrentDateString()}.xlsx`);
};

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
                        formatter: (cell) => {
                            const maxLength = 35;
                            const text = cell || 'N/A';
                            const truncated = text.length > maxLength 
                                ? text.substring(0, maxLength) + '...' 
                                : text;
                            return gridjs.html(`<span title="${text}">${truncated}</span>`);
                        },
                        sort: true,
                        width: '200px'
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



// Call this when the page loads  
  initializeCustomerTicketsTable();
  initializeSupportTicketsTable();
  initializeCustomerOnbehalfTicketsTable();
  initializeSupervisorTicketsTable();
  initializeTicketsPollTable();

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


    }

}

document.addEventListener('DOMContentLoaded', function (e) {
    new GridDatatable().init();
});


