<style>

    .filtering {
        margin-left: 5px;
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

        <form class="form-inline" method="GET" id="filtering-form">
            <input type="hidden" name="_token" value="{!! csrf_token() !!}" />

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
    </div><!-- /.panel-body -->

</div><!-- /.panel -->

<!--=== Filtering SCRIPTS ============================================ !-->

@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        updateFilteringSelectColors();
        $("#filtering-form").change(function () {
            $("#filtering-form").submit();
            $(".actual-content").fadeOut(300);
        });
        $(".filtering select").change(updateFilteringSelectColors());
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
                        console.log("user click on option  ");
                    } else {
                        //dropdown is shown
                        $(this).css('color', 'inherit');
                    }
                })
                .mouseover(function(ev) {
                    $(this).css('color', 'inherit');
                })
                .mouseout(function(ev) {
                    $(this).css('color', colorSelectGray);
                });
    }
</script>
@endpush
