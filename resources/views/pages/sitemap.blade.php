<?php echo '<?xml version="1.0" encoding="UTF-8"?>'."\n"; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

@foreach($ipes as $ipe)
    <url>
        <loc>{{url('/ipes/'.$ipe->id)}}</loc>
        <lastmod><?php echo date('Y-m-d', strtotime($ipe->timestamp)); ?></lastmod>
    </url>
@endforeach
@foreach($simulations as $simulation)
    <url>
        <loc>{{url('/simulations/'.$simulation->id)}}</loc>
        <lastmod><?php echo date('Y-m-d', strtotime($simulation->timestamp)); ?></lastmod>
    </url>
@endforeach
</urlset>
