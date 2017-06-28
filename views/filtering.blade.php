<?php
$searchValue = \Illuminate\Support\Facades\Request::get('searching');
?>

<style>

    /* ========= Filtering ============================ */

    .filtering {
        margin-left: 5px;
    }

    .filtering-form {
        display: inline-block;
    }

    .filtering .panel-title {
        margin-top: 0;
    }

    .filtering .fa-search {
        color: #666;
    }

    .filtering .form-group.inactive {
        opacity: 0.5;
        transition: all .7s;
    }

    .filtering .form-group.inactive select {
        color: inherit !important;
    }

    .filtering .form-group.inactive:hover {
        opacity: 1;
        transition: all .3s;
    }

    .filtering .form-group label {
        margin-right: 4px;
        font-weight: normal;
    }

    .filtering select {
        height: auto;
        margin-right: 15px;
        padding: 4px 6px;
        padding-right: 0;
        background-color: rgba(0,0,0,0.03);
        text-align: left;
        font-size: 95%;
    }

    .filtering select option {
        padding-right: 0;
    }

    /* ========= Searching ============================ */

    .search-form .add-on {
        margin-right: 0 !important;
    }

    .add-on .input-group-btn > .btn {
        border-left-width:0;left:-2px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    }
    /* stop the glowing blue shadow */
    .add-on .form-control:focus {
        box-shadow:none;
        -webkit-box-shadow:none; 
        border-color:#cccccc; 
    }
    .form-control{width:20%}
    .navbar-nav > li > a {
        border-right: 1px solid #ddd;
        padding-bottom: 15px;
        padding-top: 15px;
    }
    .navbar-nav:last-child{ border-right:0}

    .search-form {
        display: inline-block;
        max-width: 180px;
    }

    .search-form input {
        height: auto;
        padding: 3px 9px !important;
    }

    .search-form button[type="reset"] {
        display: none;
    }

    .search-form .btn-search-reset {
        margin: 0;
        margin-top: 2px;
        margin-left: -23px !important;
        padding: 3px 5px;
        color: #aaa;
        background-color: transparent;
        border: none;
        box-shadow: none !important;
        z-index: 4 !important;
        transition: all .8s;
    }

    .search-form .btn-search-reset:hover {
        color: #a00;
        transition: all .4s;
    }

    .search-form input::-webkit-input-placeholder { /* WebKit, Blink, Edge */
        color: #aaa;
    }
    .search-form input:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
        color: #aaa;
        opacity:  1;
    }
    .search-form input::-moz-placeholder { /* Mozilla Firefox 19+ */
        color: #aaa;
        opacity:  1;
    }
    .search-form input:-ms-input-placeholder { /* Internet Explorer 10-11 */
        color: #aaa;
    }
    .search-form input::-ms-input-placeholder { /* Microsoft Edge */
        color: #aaa;
    }

    .btn-search {
        margin: 0 !important;
        padding: 4px 7px 2px 8px !important;
        transition: .4s;
    }

    .btn-search:hover {
        color: #92e9ff;
        background-color: #1e9dda;
        transition: .4s;
    }
</style>

<div class="panel panel-default filtering">

    <div class="panel-heading with-border">

        <h4 class="panel-title">
            <i class="fa fa-search"></i>&nbsp; <span>Filter records</span>
        </h4>

        <!--        <div class="panel-tools pull-right">
                    <button class="btn btn-panel-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
                </div>-->

    </div>

    <div class="panel-body">

        <form class="form-inline filtering-form" method="GET" id="filtering-form">
        <!--<input type="hidden" name="_token" value="{!! csrf_token() !!}" />-->

            <!-- FILTER OPTION -->
            @if (!empty($filters))
            @foreach ($filters as $filterFieldName => $filterRecord)
            @foreach ($filterRecord as $filterDisplayName => $filterOptions)
            <div class="form-group {{ !$request->has($filterFieldName) ? "inactive" : "" }}">
                <label for="{{ $filterFieldName }}" class="">{{ $filterDisplayName }}:</label>
                <select name="{{ $filterFieldName }}" class="form-control">
                    <option value="">― No filter ―</option>
                    @foreach ($filterOptions as $value => $text) {
                    <option value="{{ $value }}" 
                            {{ $request->get($filterFieldName) === $value ? "selected" : "" }}
                        >{!! is_array($text) ? "Array" : $text !!}</option>
                    @endforeach
                </select>
            </div>
            @endforeach
            @endforeach

            {{-- ### Add search field not to lose it ######################################## --}}

            @if (strlen($searchValue))
            <input class="form-control search" placeholder="Search" type="hidden"
                   name="searching" value="{!! $searchValue !!}" autocomplete="off">
            @endif

            {{-- ############################################################################ --}}

            @else
            <style>
                p.error {
                    color: #a33;
                    font-weight: bold;
                }

                p.error span {
                    margin-left: 5px;
                    margin-right: 5px;
                    background-color: #eee;
                    color: #555;
                }
            </style>
            <p class="error">
                Please pass <span>$filters</span> to response e.g. using 
                <span>->with('filters', $filters)</span>
            </p>
            @endif

        </form><!-- /.filtering -->

        <div class="pull-right">

            <form class="search-form" method="GET" role="search">
                <div class="input-group add-on">
                    <input class="form-control search" placeholder="Search" name="searching" 
                           value="{!! $searchValue !!}" autocomplete="off">
                    <div class="input-group-btn">
                        <button type="reset" class="btn btn-search-reset">
                            <span class="glyphicon glyphicon-remove">
                                <span class="sr-only">Close</span>
                            </span>
                        </button>
                        <button class="btn btn-default btn-search" type="submit" 
                                title="Click to search by a keyword">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </div>
                </div>
            </form>

        </div>

    </div><!-- /.panel-body -->

</div><!-- /.panel -->

<!--=== Filtering SCRIPTS ============================================ !-->

@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {

        // === Filtering =====================================================

        updateFilteringSelectColors();
        $("#filtering-form").change(function () {
            $("#filtering-form").submit();
            $(".actual-content").fadeOut(300);
        });
        $(".filtering select").change(updateFilteringSelectColors());

        // === Searchable ====================================================

        // Remove Search if user Resets Form or hits Escape!
        $('body, .search-form button[type="reset"]').on('click keyup', function (event) {
            if (event.which == 27 && $('.search-form').hasClass('active') ||
                    $(event.currentTarget).attr('type') == 'reset') {
                searchHideResetButton();
                searchReset();
            }
        });
        
        // Show reset button on text input
        $('.search-form input').keyup(function() {
            updateSearchResetButton(this);
        });
        
        updateSearchResetButton();
        
        // =========================================================================

        function replaceRegexInUrl(replace, replacement) {
            var url = window.location + "";
            newUrl = url.replace(replace, replacement).trim();
            if (newUrl.endsWith('?')) {
                newUrl = newUrl.substring(0, newUrl.length - 2);
            }
            return newUrl;
        }

        function searchReset() {
            var newUrl = replaceRegexInUrl(/([&\?]{1}searching=[^&\s]*)/i, '');
            window.location = newUrl;
            
            showPleaseWait();
        }
        
        function searchHideResetButton() {
            var resetButton = $('.btn-search-reset');
            var field = $('.search-form input');
            resetButton.css('display', 'none');
            field.val('').focus();
        }

        function searchShowResetButton() {
            var resetButton = $('.btn-search-reset');
            resetButton.css('display', 'inline-block');
        }

        function updateSearchResetButton(input) {
            if (($('.search-form input').val() + "").length > 0) {
                searchShowResetButton();
            }
            else {
                searchHideResetButton();
            }
        }
        
    });

    // =========================================================================

    function updateFilteringSelectColors() {
        var colorSelectGray = "#aaa";

        $(".filtering select option").each(function () {
            var select = $(this).closest('select');
            var selectedValue = select.val();
            var value = $(this).val();
            var color = selectedValue ? "" : colorSelectGray;
            select.css("color", color);
        });

        $('select')
                .on('click', function (ev) {
                    if (ev.offsetY < 0) {
                    } else {
                        //dropdown is shown
                        $(this).css('color', 'inherit');
                    }
                })
                .mouseover(function (ev) {
                    $(this).css('color', 'inherit');
                })
                .mouseout(function (ev) {
                    var selectedValue = $(this).val();
                    if ((selectedValue + "").length == 0) {
                        $(this).css('color', colorSelectGray);
                    }
                });
    }
</script>
@endpush