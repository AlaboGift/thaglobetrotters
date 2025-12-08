<script type="text/javascript">
    $(function() {
        $('.note').summernote({
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript',
                    'subscript', 'clear'
                ]],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']]
                ['color', ['color']],
                ['para', ['ol', 'ul', 'paragraph', 'height']],
                ['table', ['table']],
                ['insert', ['link']],
                ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
            ]
        });
    })

    function toggleRatingView(course_id) {
        $('#course_info_view_' + course_id).toggle();
        $('#course_rating_view_' + course_id).toggle();
        $('#edit_rating_btn_' + course_id).toggle();
        $('#cancel_rating_btn_' + course_id).toggle();
    }

    function publishRating(course_id) {
        var review = $('#review_of_a_course_' + course_id).val();
        var starRating = 0;
        starRating = $('#star_rating_of_course_' + course_id).val();
        if (starRating > 0) {
            $.ajax({
                type: 'POST',
                url: "{{ url('rate-course') }}",
                data: {
                    course_id: course_id,
                    review: review,
                    starRating: starRating,
                    state: 1
                },
                success: function(response) {
                    location.reload();
                }
            });
        } else {

        }
    }

    function handleWishList(elem) {

        $.ajax({
            url: "{{ url('handle-wishlist') }}",
            type: 'POST',
            data: {
                course_id: elem.id
            },
            success: function(response) {
                if (!response) {
                    window.location.replace("{{ url('login') }}");
                } else {
                    if ($(elem).hasClass('heart-active')) {
                        $(elem).removeClass('heart-active')
                        $('.wishlist-number').html(Number($('.wishlist-number').html()) - 1)
                    } else {
                        $(elem).addClass('heart-active')
                        $('.wishlist-number').html(Number($('.wishlist-number').html()) + 1)
                    }
                    $('#wishlist_items').html(response);
                }
            }
        });
    }



    function pausePreview() {
        player.pause();
    }


    $('.toggle-course').click(function() {
        $(this).siblings().toggle();
    })

    $('.toggle-course').mouseover(function() {
        $(this).siblings().toggle();
    })


    $('.read-more').click(function() {
        $(this).siblings().toggle();

        if ($(this).siblings().is(":visible")) {
            $(this).html('<i class="fas fa-minus"></i> Read Less');
        } else {
            $(this).html('<i class="fas fa-plus"></i> Read More');
        }
    })

    $(document).on('click', '#menu', function() {
        if ($(this).hasClass('fa-chevron-down')) {
            $(this).addClass('fa-chevron-up');
            $(this).removeClass('fa-chevron-down');
        } else {
            $(this).addClass('fa-chevron-down');
            $(this).removeClass('fa-chevron-up');
        }

        $('.common-filter').each(function() {
            $(this).toggle();
        })
    })

    $(".password-toggle").on('click', function() {
        if ($(this).prev().attr("type") == "text") {
            $(this).prev().attr('type', 'password');
            $(this).children(":first").addClass("fa-eye-slash");
            $(this).children(":first").removeClass("fa-eye");
        } else if ($(this).prev().attr("type") == "password") {
            $(this).prev().attr('type', 'text');
            $(this).children(":first").removeClass("fa-eye-slash");
            $(this).children(":first").addClass("fa-eye");
        }
    });

    $('#coupon').on('input', function() {
        $('#validate').attr('disabled', false);
    })

    $('#validate').on('click', function() {
        let coupon = $('#coupon').val();
        let course = $('#course').val();
        $.ajax({
            type: "POST",
            url: "{{ url('coupons/validate-coupon') }}",
            data: {
                'coupon': coupon,
                'course': course,
                "_token": "{{ csrf_token() }}"
            },
            success: function(data) {
                if (data.toLowerCase() == coupon.toLowerCase()) {
                    $('#validate').removeClass("btn-dark");
                    $('#validate').removeClass("btn-danger");
                    $('#validate').addClass("btn-success");
                    $('#validate').html("Applied <i class='fa fa-check'></i>")
                    $('#validate').attr('disabled', true);
                    setInterval(() => {
                        location.reload();
                    }, 1000);

                } else {
                    $('#validate').removeClass("btn-dark");
                    $('#validate').addClass("btn-danger");
                    $('#validate').html("Failed <i class='fa fa-repeat'></i>")
                }

            }
        });
    })

    $('.toggle-bundle-courses').on('click', function() {
        $(this).parent().next().toggle();
        if ($(this).hasClass('fa-chevron-down')) {
            $(this).removeClass('fa-chevron-down');
            $(this).addClass('fa-chevron-up')
        } else {
            $(this).removeClass('fa-chevron-up');
            $(this).addClass('fa-chevron-down')
        }
    })

    $('#course-filter-dropdown').on('change', function() {
        var url = "{{ url('courses?') }}" + 'search=' + $('#search-query').val() + '&sort=' + $(this).val();
        window.location.replace(url);
    })


    $('#bank-verify').on('change', function() {
        let account_number = $('#account_number').val();
        $.ajax({
            type: "POST",
            url: "{{ url('profile/verify-bank-account') }}",
            data: {
                'account_number': account_number,
                'bank': $(this).val(),
                "_token": "{{ csrf_token() }}"
            },
            success: function(response) {
                let {
                    status,
                    message,
                    data
                } = jQuery.parseJSON(response);

                if (status == "success") {
                    $('#account_name').val(data.account_name);
                } else {
                    toastr.error("Invalid bank Details Provided, Please try again")
                }

            }
        });
    })

    document.addEventListener('DOMContentLoaded', function() {

        $('.close').on('click', function() {
            $('.modal').modal('hide');
        })

        $('[data-dismiss="modal"]').on('click', function() {
            $('.modal').modal('hide');
        })

        window.addEventListener("load", function() {
            $('#preloader').hide();
        });
    });

    function wordLimit(inp, limit) {
        var val = inp.value
        var words = val.split(/\s+/);
        if (words.length > limit) {
            $('.btn-limit').attr('disabled', false);
        }
    }

    function copyToClipboard(data) {
        navigator.clipboard.writeText(data)
        toastr.success('Text Copied');
    }

    function get_url() {
        var urlPrefix = "/product?";
        var urlSuffix = "";
        var slectedCategory = "";
        var selectedPrice = "";
        var selectedLevel = "";
        var selectedLanguage = "";
        var selectedRating = "";
        var selectedType = "";

        // Get selected category
        $('.categories:checked').each(function() {
            slectedCategory = $(this).attr('value');
        });

        // Get selected price
        $('.prices:checked').each(function() {
            selectedPrice = $(this).attr('value');
        });

        // Get selected difficulty Level
        $('.level:checked').each(function() {
            selectedLevel = $(this).attr('value');
        });

        // Get selected difficulty Level
        $('.languages:checked').each(function() {
            selectedLanguage = $(this).attr('value');
        });

        // Get selected rating
        $('.ratings:checked').each(function() {
            selectedRating = $(this).attr('value');
        });

        // Get selected type
        $('.types:checked').each(function() {
            selectedType = $(this).attr('value');
        });


        urlSuffix = "type=" + selectedType + "&category=" + slectedCategory + "&price=" + selectedPrice + "&level=" +
            selectedLevel +
            "&language=" + selectedLanguage + "&rating=" + selectedRating;
        var url = urlPrefix + urlSuffix;
        return url;
    }

    function filter() {
        const url = get_url();
        window.location.replace(url);
    }

    function selectedPaymentGateway(gateway) {
        $(`.payment-gateway`).css("border", "2px solid #D3DCDD");
        $('.tick-icon').hide();
        $('.form').hide();

        $(`.${gateway}`).css("border", "2px solid #00D04F");
        $(`.${gateway}-icon`).show();
        $(`.${gateway}-form`).show();
    }

    function toggleAccordionIcon(elem, section_id) {
        var accordion_section_ids = [];
        $(".accordion_icon").each(function() {
            accordion_section_ids.push(this.id);
        });
        accordion_section_ids.forEach(function(item) {
            if (item === 'accordion_icon_' + section_id) {
                if ($('#' + item).html().trim() === '<i class="fa fa-plus"></i>') {
                    $('#' + item).html('<i class="fa fa-minus"></i>')
                } else {
                    $('#' + item).html('<i class="fa fa-plus"></i>')
                }
            } else {
                $('#' + item).html('<i class="fa fa-plus"></i>')
            }
        });
    }

    window.addEventListener("load", function() {
        $('#preloader').hide();
    })

    $('.on-hover-action').mouseenter(function() {
        var id = this.id;
        $('#widgets-of-' + id).show();
    });
    $('.on-hover-action').mouseleave(function() {
        var id = this.id;
        $('#widgets-of-' + id).hide();
    });

    function showAjaxModal(url, header) {
        // SHOWING AJAX PRELOADER IMAGE
        jQuery('#scrollable-modal .modal-body').html(
            '<div style="text-align:center;"><img src="{{ asset('public/global/bg-pattern-light.svg') }}" /></div>'
        );
        jQuery('#scrollable-modal .modal-title').html('...');
        // LOADING THE AJAX MODAL
        jQuery('#scrollable-modal').modal('show', {
            backdrop: 'true'
        });

        // SHOW AJAX RESPONSE ON REQUEST SUCCESS
        $.ajax({
            url: url,
            success: function(response) {
                jQuery('#scrollable-modal .modal-body').html(response);
                jQuery('#scrollable-modal .modal-title').html(header);
            }
        });
    }

    function showLargeModal(url, header) {
        // SHOWING AJAX PRELOADER IMAGE
        jQuery('#large-modal .modal-body').html(
            '<div style="text-align:center;margin-top:200px;"><img src="{{ asset('public/global/bg-pattern-light.svg') }}" height = "50px" /></div>'
        );
        jQuery('#large-modal .modal-title').html('...');
        // LOADING THE AJAX MODAL
        jQuery('#large-modal').modal('show', {
            backdrop: 'true'
        });

        // SHOW AJAX RESPONSE ON REQUEST SUCCESS
        $.ajax({
            url: url,
            success: function(response) {
                jQuery('#large-modal .modal-body').html(response);
                jQuery('#large-modal .modal-title').html(header);
            }
        });
    }
    //Currency Dropdown

    $(".dropdown img.flag").addClass("flagvisibility");
    $(".dropdown dt a").click(function() {
        $(".dropdown dd ul").toggle();
    });

    $(".dropdown dd ul li a").click(function() {
        var text = $(this).html();
        $(".dropdown dt a span").html(text);
        $(".dropdown dd ul").hide();
        $("#result").html("Selected value is: " + getSelectedValue("sample"));
    });

    function getSelectedValue(id) {
        return $("#" + id)
            .find("dt a span.value")
            .html();
    }

    $(document).bind("click", function(e) {
        var $clicked = $(e.target);
        if (!$clicked.parents().hasClass("dropdown")) $(".dropdown dd ul").hide();
    });

    $(".dropdown img.flag").toggleClass("flagvisibility");

    function publishProduct(productId) {
        $.ajax({
            type: 'GET',
            url: '{{ url('products/publish') }}/' + productId,
            success: function(response) {
                console.log(response);
            }
        });
    }

    function publishCurrency(currencyId) {
        $.ajax({
            type: 'GET',
            url: '{{ url('settings/currencies/publish') }}/' + currencyId,
            success: function(response) {
                console.log(response);
            }
        });
    }

    function showInHome(productId) {
        $.ajax({
            type: 'GET',
            url: '{{ url('products/show-home') }}/' + productId,
            success: function(response) {
                console.log(response);
            }
        });
    }

    $('#subscribe').on('click', function() {
        $(this).prop('disabled', true);
        $(this).html('<i class="fas fa-spinner fa-spin"></i>');
        $('#paymentForm').submit();
    });
</script>
<x-modals />
