<table class="form-table">
    <tr>
        <th scope="row">
            <label for="from">게시 시작일</label>
        </th>
        <td>
            <input type="text" name="meta[from]" id="from" class="js-datepicker" data-date-format="yy-mm-dd"
                value="<?= get_post_meta(get_the_ID(), 'from', true) ?: date('Y-m-d') ?>">
        </td>
    </tr>
    <tr>
        <th scope="row">
            <label for="from">게시 종료일</label>
        </th>
        <td>
            <input type="text" name="meta[to]" id="to" class="js-datepicker" data-date-format="yy-mm-dd"
                   value="<?= get_post_meta(get_the_ID(), 'to', true) ?>">
            <p class="description">게시 종료일을 비워두면 계속 게시합니다.</p>
        </td>
    </tr>
    <tr>
        <th scope="row">
            <label for="link">링크</label>
        </th>
        <td>
            <input type="text" class="regular-text code" name="meta[link]" id="link"
                   placeholder="https://example.com"
                   value="<?= get_post_meta(get_the_ID(), 'link', true) ?>">
            <p class="description">비워 두면 텍스트만 나옵니다.</p>
        </td>
    </tr>
</table>

<script>
    (function () {
        var $ = jQuery;
        if (typeof $.datepicker != 'undefined') {
            $('.js-datepicker').each(function (i, el) {
                var dateFormat = $(el).data('date-format') || 'yy-mm-dd';
                $(el).datepicker({
                    dateFormat: dateFormat,
                    changeMonth: true,
                    changeYear: true
                });
            });
        }
    }());
</script>