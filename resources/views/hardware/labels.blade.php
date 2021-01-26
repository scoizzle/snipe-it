<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Labels</title>

</head>
<body>

<style>
    body {
        display: grid;

        column-gap: {{ $settings->labels_display_sgutter }}in;
        grid-template-rows: repeat({{ floor($settings->labels_pagewidth / $settings->labels_width) }}, {{ $settings->labels_width }}in);

        font-size: {{ $settings->labels_fontsize }}pt;
        font-family: arial, helvetica, sans-serif;

        width: {{ $settings->labels_pagewidth }}in;
        height: {{ $settings->labels_pageheight }}in;

        margin: 0px;
        padding-top: {{ $settings->labels_pmargin_top }}in;
        padding-right: {{ $settings->labels_pmargin_right }}in;
        padding-bottom: {{ $settings->labels_pmargin_bottom }}in;
        padding-left: {{ $settings->labels_pmargin_left }}in;
    }

    .label {
        display: grid;
        
        column-gap: .15in;
        grid-template-areas:
            "qr_text    qr_text     qr_text"
            "qr_img     company     company"
            "qr_img     name        name"
            "qr_img     tag         tag"
            "qr_img     model       model"
            "qr_img     serial      serial"
            "barcode    barcode     barcode";

        width: {{ $settings->labels_width }}in;
        height: {{ $settings->labels_height }}in;

        padding: 0.05in 0.25in;
        display: inline-block;
        overflow: hidden;
    }

    .page-break  {
        page-break-after: always;
    }

    div.company { grid-area: company; }
    div.name { grid-area: name; }
    div.tag { grid-area: tag; }
    div.model { grid-area: model; }
    div.serial { grid-area: serial; }

    img.qr_img { grid-area: qr_img; }

    .qr_text {
        grid-area: qr_text;

        font-family: arial, helvetica, sans-serif;
        font-size: {{$settings->labels_fontsize}};
        overflow: hidden !important;
        display: inline;
        word-wrap: break-word;
        word-break: break-all;
    }

    img.barcode {
        grid-area: barcode

        width: 100%;
        display: inline;
        overflow: hidden;

        padding-top: .11in;
    }


    @media screen {
        .label {
            outline: .02in black solid;
        }
    }

    @if ($snipeSettings->custom_css)
        {{ $snipeSettings->show_custom_css() }}
    @endif
</style>

@foreach ($assets as $asset)
    <?php $count++; ?>
    <div class="label">

        @if ($settings->qr_code=='1')
            <img src="./{{ $asset->id }}"/qr_code" class="qr_img">
        @endif

        
        @if ($settings->qr_text!='')
            <strong class="qr_text">>{{ $settings->qr_text }}</strong>
        @endif

        @if (($settings->labels_display_company_name=='1') && ($asset->company))
            <div class="pull-left company">
                C: {{ $asset->company->name }}
            </div>
        @endif

        @if (($settings->labels_display_name=='1') && ($asset->name!=''))
            <div class="pull-left name">
                N: {{ $asset->name }}
            </div>
        @endif

        @if (($settings->labels_display_tag=='1') && ($asset->asset_tag!=''))
            <div class="pull-left tag">
                T: {{ $asset->asset_tag }}
            </div>
        @endif

        @if (($settings->labels_display_serial=='1') && ($asset->serial!=''))
            <div class="pull-left serial">
                S: {{ $asset->serial }}
            </div>
        @endif

        @if (($settings->labels_display_model=='1') && ($asset->model->name!=''))
            <div class="pull-left model">
                M: {{ $asset->model->name }} {{ $asset->model->model_number }}
            </div>
        @endif

        @if ((($settings->alt_barcode_enabled=='1') && $settings->alt_barcode!=''))
            <img src="./{{ $asset->id }}/barcode" class="barcode">
        @endif
    </div>

    @if ($count % $settings->labels_per_page != 0)
        <div class="page-break"></div>
        <div class="next-padding">&nbsp;</div>
    @endif

@endforeach


</body>
</html>