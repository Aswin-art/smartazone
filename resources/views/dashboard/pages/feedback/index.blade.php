@extends('dashboard.layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row gy-6">
                <!-- Statistics Cards -->
                <div class="col-xl-12">
                    <div class="row gy-6">
                        <div class="col-md-3 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="badge rounded-pill bg-label-success me-3 p-2">
                                            <i class="ri-star-line ri-22px"></i>
                                        </div>
                                        <div class="card-info">
                                            <h5 class="mb-0" id="totalReviews">0</h5>
                                            <small class="text-muted">Total Reviews</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="badge rounded-pill bg-label-warning me-3 p-2">
                                            <i class="ri-star-fill ri-22px"></i>
                                        </div>
                                        <div class="card-info">
                                            <h5 class="mb-0" id="avgRating">0.0</h5>
                                            <small class="text-muted">Average Rating</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="badge rounded-pill bg-label-primary me-3 p-2">
                                            <i class="ri-mountain-line ri-22px"></i>
                                        </div>
                                        <div class="card-info">
                                            <h5 class="mb-0" id="totalMountains">0</h5>
                                            <small class="text-muted">Mountains Reviewed</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="badge rounded-pill bg-label-info me-3 p-2">
                                            <i class="ri-calendar-line ri-22px"></i>
                                        </div>
                                        <div class="card-info">
                                            <h5 class="mb-0" id="thisMonth">0</h5>
                                            <small class="text-muted">This Month</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Feedback Management Table -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Feedback & Rating Management</h5>
                        <div class="card-header-elements">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search feedback..."
                                style="width: 250px;">
                        </div>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table" id="feedbackTable">
                            <thead>
                                <tr>
                                    <th>Hiker</th>
                                    <th>Mountain</th>
                                    <th>Rating</th>
                                    <th>Comment</th>
                                    <th>Hike Period</th>
                                    <th>Review Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                <!-- Data will be loaded via AJAX -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Loading spinner -->
                    <div id="loadingSpinner" class="text-center p-4" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    <!-- No data message -->
                    <div id="noDataMessage" class="text-center p-4" style="display: none;">
                        <p class="text-muted">No feedback found.</p>
                    </div>

                    <!-- Pagination -->
                    <div class="card-footer">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <span id="tableInfo" class="text-muted">Showing 0 to 0 of 0 entries</span>
                            </div>
                            <div class="col-md-6">
                                <nav aria-label="Table pagination">
                                    <ul class="pagination justify-content-end mb-0" id="pagination">
                                        <!-- Pagination will be generated by JavaScript -->
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Feedback Detail Modal -->
        <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="feedbackModalLabel">Feedback Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="feedbackDetails">
                            <!-- Details will be loaded here -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <footer class="content-footer footer bg-footer-theme">
            <div class="container-xxl">
                <div
                    class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                    <div class="mb-2 mb-md-0">
                        &#169;
                        <script>
                            document.write(new Date().getFullYear());
                        </script>, Mountain Management System
                    </div>
                </div>
            </div>
        </footer>

        <div class="content-backdrop fade"></div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let currentPage = 1;
            let itemsPerPage = 10;
            let searchTerm = '';
            let totalRecords = 0;

            loadFeedback();
            loadStats();

            let searchTimeout;
            $('#searchInput').on('keyup', function() {
                clearTimeout(searchTimeout);
                searchTerm = $(this).val();
                searchTimeout = setTimeout(function() {
                    currentPage = 1;
                    loadFeedback();
                }, 500);
            });

            function loadFeedback() {
                showLoading();
                $.ajax({
                    url: '{{ route('feedback.getData') }}',
                    type: 'GET',
                    data: {
                        search: searchTerm,
                        start: (currentPage - 1) * itemsPerPage,
                        length: itemsPerPage,
                        order_column: 'mf.created_at',
                        order_dir: 'desc'
                    },
                    success: function(response) {
                        hideLoading();
                        totalRecords = response.recordsTotal;
                        if (response.data && response.data.length > 0) {
                            renderTable(response.data);
                            renderPagination();
                            updateTableInfo();
                            $('#noDataMessage').hide();
                        } else {
                            $('#feedbackTable tbody').empty();
                            $('#pagination').empty();
                            $('#tableInfo').text('Showing 0 to 0 of 0 entries');
                            $('#noDataMessage').show();
                        }
                    },
                    error: function(xhr, status, error) {
                        hideLoading();
                        console.error('Error loading feedback:', error);
                        alert('Error loading data. Please try again.');
                    }
                });
            }

            function loadStats() {
                $.ajax({
                    url: '{{ route('feedback.stats') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response && response.length > 0) {
                            let totalReviews = 0;
                            let totalRating = 0;
                            let totalMountains = response.length;

                            response.forEach(function(item) {
                                totalReviews += parseInt(item.total_reviews);
                                totalRating += parseFloat(item.avg_rating);
                            });

                            let avgRating = totalMountains > 0 ? (totalRating / totalMountains).toFixed(
                                1) : 0;

                            $('#totalReviews').text(totalReviews);
                            $('#avgRating').text(avgRating);
                            $('#totalMountains').text(totalMountains);

                            // Calculate this month's reviews (you might want to add this to backend)
                            $('#thisMonth').text('0'); // Placeholder
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading stats:', error);
                    }
                });
            }

            function renderTable(data) {
                let html = '';
                data.forEach(function(feedback) {
                    let stars = generateStars(feedback.rating);
                    let comment = feedback.comment.length > 50 ?
                        feedback.comment.substring(0, 50) + '...' :
                        feedback.comment;

                    html += `
                <tr>
                    <td>
                        <i class="icon-base ri ri-user-3-line icon-22px text-info me-3"></i>
                        <div>
                            <span class="fw-medium">${feedback.user_name}</span><br>
                            <small class="text-muted">${feedback.email}</small>
                        </div>
                    </td>
                    <td>
                        <i class="icon-base ri ri-mountain-line icon-22px text-success me-2"></i>
                        ${feedback.mountain_name}
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="rating-stars me-2">
                                ${stars}
                            </div>
                            <span class="badge bg-label-primary">${feedback.rating}/5</span>
                        </div>
                    </td>
                    <td>
                        <span class="text-wrap" style="max-width: 200px; display: inline-block;" 
                              title="${feedback.comment}">${comment}</span>
                    </td>
                    <td>
                        <small class="text-muted">
                            <i class="ri-calendar-line me-1"></i>
                            ${feedback.hike_date} - ${feedback.return_date}
                        </small>
                    </td>
                    <td>
                        <small class="text-muted">${feedback.created_at}</small>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow shadow-none" data-bs-toggle="dropdown">
                                <i class="icon-base ri ri-more-2-line icon-18px"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0);" onclick="viewFeedback(${feedback.feedback_id})">
                                    <i class="icon-base ri ri-eye-line icon-18px me-2"></i>
                                    View Details
                                </a>
                                <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="deleteFeedback(${feedback.feedback_id})">
                                    <i class="icon-base ri ri-delete-bin-6-line icon-18px me-2"></i>
                                    Delete
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
            `;
                });
                $('#feedbackTable tbody').html(html);
            }

            function generateStars(rating) {
                let stars = '';
                for (let i = 1; i <= 5; i++) {
                    if (i <= rating) {
                        stars += '<i class="ri-star-fill text-warning"></i>';
                    } else {
                        stars += '<i class="ri-star-line text-muted"></i>';
                    }
                }
                return stars;
            }

            function renderPagination() {
                const totalPages = Math.ceil(totalRecords / itemsPerPage);
                let html = '';
                if (totalPages <= 1) {
                    $('#pagination').empty();
                    return;
                }
                html += `
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" href="javascript:void(0);" onclick="changePage(${currentPage - 1})">
                    <i class="ri-arrow-left-s-line"></i>
                </a>
            </li>
        `;
                const startPage = Math.max(1, currentPage - 2);
                const endPage = Math.min(totalPages, startPage + 4);
                if (startPage > 1) {
                    html +=
                        `<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="changePage(1)">1</a></li>`;
                    if (startPage > 2) {
                        html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                    }
                }
                for (let i = startPage; i <= endPage; i++) {
                    html += `
                <li class="page-item ${i === currentPage ? 'active' : ''}">
                    <a class="page-link" href="javascript:void(0);" onclick="changePage(${i})">${i}</a>
                </li>
            `;
                }
                if (endPage < totalPages) {
                    if (endPage < totalPages - 1) {
                        html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                    }
                    html +=
                        `<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="changePage(${totalPages})">${totalPages}</a></li>`;
                }
                html += `
            <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="javascript:void(0);" onclick="changePage(${currentPage + 1})">
                    <i class="ri-arrow-right-s-line"></i>
                </a>
            </li>
        `;
                $('#pagination').html(html);
            }

            window.changePage = function(page) {
                if (page < 1 || page > Math.ceil(totalRecords / itemsPerPage)) return;
                currentPage = page;
                loadFeedback();
            };

            function updateTableInfo() {
                const start = (currentPage - 1) * itemsPerPage + 1;
                const end = Math.min(currentPage * itemsPerPage, totalRecords);
                $('#tableInfo').text(`Showing ${start} to ${end} of ${totalRecords} entries`);
            }

            function showLoading() {
                $('#loadingSpinner').show();
                $('#feedbackTable tbody').empty();
                $('#noDataMessage').hide();
            }

            function hideLoading() {
                $('#loadingSpinner').hide();
            }

            window.viewFeedback = function(feedbackId) {
                $.ajax({
                    url: `/feedback/${feedbackId}`,
                    type: 'GET',
                    success: function(response) {
                        let stars = generateStars(response.rating);
                        let detailsHtml = `
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Hiker Information</h6>
                            <p><strong>Name:</strong> ${response.user_name}</p>
                            <p><strong>Email:</strong> ${response.email}</p>
                            <p><strong>Phone:</strong> ${response.phone || '-'}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Mountain & Hiking Details</h6>
                            <p><strong>Mountain:</strong> ${response.mountain_name}</p>
                            <p><strong>Location:</strong> ${response.mountain_location}</p>
                            <p><strong>Team Size:</strong> ${response.team_size} people</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Hiking Period</h6>
                            <p><strong>Start Date:</strong> ${response.hike_date}</p>
                            <p><strong>End Date:</strong> ${response.return_date}</p>
                            <p><strong>Check-in:</strong> ${response.checkin_time ? new Date(response.checkin_time).toLocaleString() : '-'}</p>
                            <p><strong>Check-out:</strong> ${response.checkout_time ? new Date(response.checkout_time).toLocaleString() : '-'}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Rating & Feedback</h6>
                            <div class="mb-3">
                                <div class="rating-stars mb-2">
                                    ${stars}
                                </div>
                                <span class="badge bg-label-primary fs-6">${response.rating}/5 Stars</span>
                            </div>
                            <p><strong>Review Date:</strong> ${new Date(response.created_at).toLocaleString()}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-muted">Comment</h6>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <p class="mb-0">${response.comment || 'No comment provided.'}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                        $('#feedbackDetails').html(detailsHtml);
                        $('#feedbackModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        alert('Error loading feedback details. Please try again.');
                    }
                });
            };

            window.deleteFeedback = function(feedbackId) {
                if (confirm(
                        'Apakah Anda yakin ingin menghapus feedback ini? Tindakan ini tidak dapat dibatalkan.'
                        )) {
                    $.ajax({
                        url: "{{ route('feedback.destroy', ':id') }}".replace(':id', feedbackId),
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            alert('Feedback berhasil dihapus');
                            loadFeedback();
                            loadStats();
                        },
                        error: function(xhr, status, error) {
                            alert('Terjadi kesalahan saat menghapus feedback. Silakan coba lagi.');
                        }
                    });
                }
            };

        });
    </script>
@endpush
