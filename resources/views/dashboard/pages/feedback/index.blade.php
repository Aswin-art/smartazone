@extends('dashboard.layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row gy-6">
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
                            <tbody class="table-border-bottom-0"></tbody>
                        </table>
                    </div>
                    <div id="loadingSpinner" class="text-center p-4" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div id="noDataMessage" class="text-center p-4" style="display: none;">
                        <p class="text-muted">No feedback found.</p>
                    </div>
                    <div class="card-footer">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <span id="tableInfo" class="text-muted">Showing 0 to 0 of 0 entries</span>
                            </div>
                            <div class="col-md-6">
                                <nav aria-label="Table pagination">
                                    <ul class="pagination justify-content-end mb-0" id="pagination"></ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="feedbackModalLabel">Feedback Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" id="feedbackDetails"></div>
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
            let currentPage = 1,
                itemsPerPage = 10,
                searchTerm = '',
                totalRecords = 0;
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
                    error: function() {
                        hideLoading();
                        alert('Error loading data. Please try again.');
                    }
                });
            }

            function loadStats() {
                $.ajax({
                    url: '{{ route('feedback.stats') }}',
                    type: 'GET',
                    success: function(response) {
                        let stats = response.stats_by_mountain || [];
                        let totalFeedbacks = response.total_feedbacks || 0;
                        let avgOverallRating = response.avg_overall_rating || 0;
                        if (stats.length > 0) {
                            let totalReviews = 0,
                                totalRating = 0,
                                totalMountains = stats.length;
                            stats.forEach(function(item) {
                                totalReviews += parseInt(item.total_reviews);
                                totalRating += parseFloat(item.avg_rating);
                            });
                            let avgRating = totalMountains > 0 ? (totalRating / totalMountains).toFixed(
                                1) : 0;
                            $('#totalReviews').text(totalReviews);
                            $('#avgRating').text(avgRating);
                            $('#totalMountains').text(totalMountains);
                        } else {
                            $('#totalReviews').text(0);
                            $('#avgRating').text(0);
                            $('#totalMountains').text(0);
                        }
                        $('#thisMonth').text('0');
                    }
                });
            }

            function renderTable(data) {
                let html = '';
                data.forEach(function(feedback) {
                    let stars = generateStars(feedback.rating);
                    let comment = feedback.comment.length > 50 ? feedback.comment.substring(0, 50) + '...' :
                        feedback.comment;
                    html += `
            <tr>
                <td><i class="ri-user-3-line text-info me-2"></i>${feedback.user_name}</td>
                <td><i class="ri-mountain-line text-success me-2"></i>${feedback.mountain_name}</td>
                <td><div class="d-flex align-items-center">${stars}<span class="badge bg-label-primary ms-2">${feedback.rating}/5</span></div></td>
                <td><span title="${feedback.comment}">${comment}</span></td>
                <td><small class="text-muted">${feedback.hike_date} - ${feedback.return_date}</small></td>
                <td><small class="text-muted">${feedback.created_at}</small></td>
                <td>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-info waves-effect waves-light" 
                                onclick="viewFeedback(${feedback.feedback_id})">
                            <i class="ri-eye-line me-1"></i>
                            <span class="d-none d-lg-inline">Lihat</span>
                        </button>
                        <button class="btn btn-sm btn-danger waves-effect waves-light" 
                                onclick="deleteFeedback(${feedback.feedback_id})">
                            <i class="ri-delete-bin-line me-1"></i>
                            <span class="d-none d-lg-inline">Hapus</span>
                        </button>
                    </div>
                </td>
            </tr>`;
                });
                $('#feedbackTable tbody').html(html);
            }

            function generateStars(rating) {
                let stars = '';
                for (let i = 1; i <= 5; i++) {
                    stars += i <= rating ? '<i class="ri-star-fill text-warning"></i>' :
                        '<i class="ri-star-line text-muted"></i>';
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
                html +=
                    `<li class="page-item ${currentPage===1?'disabled':''}"><a class="page-link" href="javascript:void(0);" onclick="changePage(${currentPage-1})"><i class="ri-arrow-left-s-line"></i></a></li>`;
                const startPage = Math.max(1, currentPage - 2);
                const endPage = Math.min(totalPages, startPage + 4);
                if (startPage > 1) html +=
                    `<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="changePage(1)">1</a></li>`;
                for (let i = startPage; i <= endPage; i++) {
                    html +=
                        `<li class="page-item ${i===currentPage?'active':''}"><a class="page-link" href="javascript:void(0);" onclick="changePage(${i})">${i}</a></li>`;
                }
                if (endPage < totalPages) html +=
                    `<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="changePage(${totalPages})">${totalPages}</a></li>`;
                html +=
                    `<li class="page-item ${currentPage===totalPages?'disabled':''}"><a class="page-link" href="javascript:void(0);" onclick="changePage(${currentPage+1})"><i class="ri-arrow-right-s-line"></i></a></li>`;
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
                    url: "{{ route('feedback.show', ':id') }}".replace(':id', feedbackId),
                    type: 'GET',
                    success: function(response) {
                        let stars = generateStars(response.rating);
                        let detailsHtml = `
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Name:</strong> ${response.user_name}</p>
                            <p><strong>Email:</strong> ${response.email}</p>
                            <p><strong>Phone:</strong> ${response.phone || '-'}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Mountain:</strong> ${response.mountain_name}</p>
                            <p><strong>Location:</strong> ${response.mountain_location}</p>
                            <p><strong>Team Size:</strong> ${response.team_size}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Hike:</strong> ${response.hike_date} - ${response.return_date}</p>
                            <p><strong>Check-in:</strong> ${response.checkin_time || '-'}</p>
                            <p><strong>Check-out:</strong> ${response.checkout_time || '-'}</p>
                        </div>
                        <div class="col-md-6">
                            <div>${stars}</div>
                            <span class="badge bg-primary">${response.rating}/5</span>
                            <p><strong>Review Date:</strong> ${response.created_at}</p>
                        </div>
                    </div>
                    <hr>
                    <p><strong>Comment:</strong></p>
                    <div class="alert alert-light border">${response.comment || 'No comment provided.'}</div>`;
                        $('#feedbackDetails').html(detailsHtml);
                        $('#feedbackModal').modal('show');
                    },
                    error: function() {
                        alert('Error loading feedback details.');
                    }
                });
            };

            window.deleteFeedback = function(feedbackId) {
                if (confirm('Apakah Anda yakin ingin menghapus feedback ini?')) {
                    $.ajax({
                        url: "{{ route('feedback.destroy', ':id') }}".replace(':id', feedbackId),
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            alert('Feedback berhasil dihapus');
                            loadFeedback();
                            loadStats();
                        },
                        error: function() {
                            alert('Terjadi kesalahan saat menghapus feedback.');
                        }
                    });
                }
            };
        });
    </script>
@endpush
