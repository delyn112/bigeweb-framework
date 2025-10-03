<?php

namespace illuminate\Support\Database;

trait Paginator
{

    public $total_records;
    public $current_page;
    public $total_pages;
    public $row_per_page;


    public function paginate(int $number_per_page, $currentPage = 1)
    {
        if($number_per_page > 0)
        {
            $total_param_rows = count($this->executeQuery());
            //calculate the total pages
            $totalPages = ceil($total_param_rows / $number_per_page);
            //calculate the offset
            if(isset($_GET['page']))
            {
                $currentPage = $_GET['page'];
            }
            $offset = ($currentPage - 1) * $number_per_page;
            $this->limit($number_per_page, $offset);


            //set the record to be available publicly
            $this->total_records = $total_param_rows;
            $this->current_page = $currentPage;
            $this->total_pages = $totalPages;
            $this->row_per_page = $number_per_page;
           return $this;
        }
    }


    public function pagination_link()
    {
        $paginatedData = $this;
        $html = '<ul class="pagination bgw-pagination mb-0">';

// Parse the current URL
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $query = [];
        parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $query);

// Remove existing 'page' parameter if it exists
        unset($query['page']);

// Function to build the new URL with page
        function buildPageLink($path, $query, $page)
        {
            $query['page'] = $page;
            return $path . '?' . http_build_query($query);
        }

// Previous Page Button
        $prevPage = ($paginatedData->current_page > 1) ? $paginatedData->current_page - 1 : 1;
        $html .= '<li class="page-item">';
        $html .= '<a class="page-link" href="' . url(ltrim(buildPageLink($path, $query, $prevPage), '/')) . '"><i class="fa-solid fa-chevron-left"></i></a>';
        $html .= '</li>';

// Page Numbers
       if($paginatedData->total_pages > 0 && $paginatedData->total_pages < 5)
       {
           if ($paginatedData->total_pages >= 1) {
               for ($page = 1; $page <= $paginatedData->total_pages; $page++) {
                   $activeClass = ($page == $paginatedData->current_page) ? ' active' : '';
                   $html .= '<li class="page-item' . $activeClass . '">';
                   $html .= '<a class="page-link" href="' . url(ltrim(buildPageLink($path, $query, $page), '/')) . '">' . $page . '</a>';
                   $html .= '</li>';
               }
           }
       }

// Next Page Button
        $nextPage = ($paginatedData->current_page < $paginatedData->total_pages) ? $paginatedData->current_page + 1 : $paginatedData->total_pages;
        $html .= '<li class="page-item">';
        $html .= '<a class="page-link" href="' . url(ltrim(buildPageLink($path, $query, $nextPage), '/')) . '"><i class="fa-solid fa-chevron-right"></i></a>';
        $html .= '</li>';

        $html .= '</ul>';


                $showingFrom = ($paginatedData->current_page - 1) * $paginatedData->row_per_page + 1;
        $showingTo = min($paginatedData->current_page * $paginatedData->row_per_page, $paginatedData->total_records);
        $total = $paginatedData->total_records;


                $newhtml = '<div class="d-flex justify-content-between align-items-center paginator-wrapper mt-5 mb-5">';
        $newhtml .= '<div class="bg-w paginator-info"> <span class="me-2">
                        <i class="fa-solid fa-globe"></i></span>';
        $newhtml .= "Show $showingFrom to $showingTo of $total entries </div>";
        $newhtml .= $html;

        return ($newhtml);

    }
}