<div class="box box-default filtering">

    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-search" style="color: #666;"></i>&nbsp; <span>Filter records</span></h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->

    <div class="box-body">
        <form class="form-inline" method="GET" id="filtering-form">
            <input type="hidden" name="_token" value="{!! csrf_token() !!}" />

            <!-- FILTER OPTION -->
            @if (!empty($filters))
            @foreach ($filters as $filterFieldName => $filterRecord)
            @foreach ($filterRecord as $filterDisplayName => $filterOptions)
            <div class="form-group">
                <label for="{{ $filterFieldName }}" class="">{{ $filterDisplayName }}:</label>
                <select name="{{ $filterFieldName }}" class="form-control">
                    <option value="">------ No filter ------</option>
                    @foreach ($filterOptions as $value => $text) {
                    <option value="{{ $value }}" 
                            {{ $request->get($filterFieldName) === $value ? "selected" : "" }}
                        >{!! is_array($text) ? "Array" : $text !!}</option>
                    @endforeach
                </select>
            </div>
            @endforeach
            @endforeach

            <script type="text/javascript">
                function updateFilteringSelectColors() {
                    $(".filtering select").each(function () {
                        var value = $(this).val();
                        var color = value ? "inherit" : "#aaa";
                        $(this).css("color", color);
                    });
                }

                window.initQueue.push(function () {
                    updateFilteringSelectColors();

                    $("#filtering-form").change(function () {
                        showPleaseWait();
                        $("#filtering-form").submit();
                    });

                    $(".filtering select").change(updateFilteringSelectColors());
                });
            </script>

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
    </div><!-- /.box-body -->

</div><!-- /.box -->