<?php
// pagination class
class Pagination
{
    /**
     * 전체 row 갯수 - 페이지수 계산에 아용함.
     *
     * @var int $totalRows
     */
    private $totalRows;

    /**
     * 페이지당 보여줄 row 갯수
     *
     * @var int $rowsPerPage
     */
    private $rowsPerPage;

    /**
     * 페이지 갯수 ($totalRows / $rowsPerPage)
     *
     * @var int $rowsPerPage
     */
    private $totalPages;

    /**
     * 블럭사이즈
     *
     * @var int $blockSize  전체 row 갯수
     */
    private $blockSize;

    /**
     * 현재페이지 정보
     *
     * @var int $currentPage
     */
    private $currentPage;

    /**
     * 페이지 링크를 만들 URL
     *
     * @var string $url
     */
    private $url;

    /**
     * 생성자
     *
     * @param   Int $total_rows     전체 row 갯수
     * @param   Int $rows_per_page  페이지당 row 갯수
     * @param   Int $block_size     보여질 페이지 번호
     * @param   Int $current_page   현재 페이지 번호
     */
    public function __construct($total_rows, $rows_per_page, $url, $block_size = 10, $current_page = 1)
    {
        $this->totalRows = $total_rows;
        $this->rowsPerPage = $rows_per_page;
        $this->blockSize = $block_size;
        $this->currentPage = $current_page;
        $this->url = $url;
    }

    /**
     * 페이징 테스트
     *
     */
    public function paging($url)
    {
        $this->currentPage = isset($_GET['page']) ? $_GET["page"] : 1;

        $start_page = (((int) (($this->currentPage - 1) / $this->blockSize)) * $this->blockSize) + 1;
        $end_page = $start_page + $this->blockSize - 1;

        if ($this->currentPage > 1) {
            echo "<a>Prev</a> ";
        }
        for ($i = $start_page; $i <= $end_page; $i++) {
            $link = $url . "?page=" . $i;
            if ($i == $this->currentPage) {
                echo "<a href=\"$link\">[$i]</a> ";
            } else {
                echo "<a href=\"$link\">$i</a> ";
            }
        }
        if ($this->totalPages > 10) {
            echo "<a>Next</a> ";
        }
    }

    /**
     * 부투스트랩 5.2을 적용한 페이징처리
     *
     */
    // determine what the current page is also, it returns the current page
    public function createBootstrap5Links()
    {
        $this->currentPage = isset($_GET['page']) ? $_GET["page"] : 1;
        $this->totalPages = ceil($this->totalRows / $this->rowsPerPage);

        $query_string_location = strpos($this->url, '?');
        if ($query_string_location) {
            $this->url = substr($this->url, 0, $query_string_location);
        }

        if ($this->totalPages < 2) {
            return '';
        }

        $start_page = (((int) (($this->currentPage - 1) / $this->blockSize)) * $this->blockSize) + 1;
        $end_page = $start_page + $this->blockSize - 1;
        if ($this->totalPages < $end_page) {
            $end_page = $this->totalPages;
        }

        $output = '<nav aria-label="">' . PHP_EOL;
        $output .= '<ul class="pagination justify-content-center">' . PHP_EOL;
        if ($this->currentPage > 1) {
            $output .= '<li class="page-item"><a class="page-link" href="' . $this->url . '?page=' . ($this->currentPage - 1) . '">Previous</a></li>' . PHP_EOL;
            $output .= '<li class="page-item"><a class="page-link" href="' . $this->url . '?page=1"><span aria-hidden="true">&laquo;</span></a></li>';
        }

        for ($i = $start_page; $i <= $end_page; $i++) {
            if ($i == $this->currentPage)
              $output .= '<li class="page-item active"><a class="page-link" href="' . $this->url . '?page=' . $i . '">' . $i . '</a></li>' . PHP_EOL;
            else
              $output .= '<li class="page-item"><a class="page-link" href="' . $this->url . '?page=' . $i . '">' . $i . '</a></li>' . PHP_EOL;
        }

        if ($this->currentPage < $this->totalPages) {
            $output .= '<li class="page-item"><a class="page-link" href="' . $this->url . '?page=' . $this->totalPages . '"><span aria-hidden="true">&raquo;</span></a></li>';
            $output .= '<li class="page-item"><a class="page-link" href="' . $this->url . '?page=' . ($this->currentPage + 1) . '">Next</a></li>' . PHP_EOL;
        }
        $output .= '</ul>' . PHP_EOL;
        $output .= '</nav>' . PHP_EOL;

        return $output;
    }
}