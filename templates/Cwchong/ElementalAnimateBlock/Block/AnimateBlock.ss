<% if $Title && $ShowTitle %>
    <h2 class="animate-element__title">$Title</h2>
<% else %>
    <br />
<% end_if %>
<div class="animate-element__images">
    <% if $MobileImage %><p class="mobile">$MobileImage</p><% end_if %>
    <% if $Image %><div class="animate-img">
        <% loop $TextBlocks %><div data-aos="fade-{$Direction}"
            style="
                <% if $OffsetLeft %>left: {$OffsetLeft};<% end_if %>
                <% if $OffsetRight %>right: {$OffsetRight};<% end_if %>
                <% if $OffsetTop %>top: {$OffsetTop};<% end_if %>
                <% if $OffsetBottom %>bottom: {$OffsetBottom};<% end_if %>
            "
        >
            $Content
        </div><% end_loop %>
        <p>$Image</p>
    </div><% end_if %>
    <br /><br />
</div>

<% require css('https://unpkg.com/aos@next/dist/aos.css') %>
<% require javascript('https://unpkg.com/aos@next/dist/aos.js') %>
<% require javascript('cwchong/elemental-animateblock:client/dist/js/animation-scroll.js') %>