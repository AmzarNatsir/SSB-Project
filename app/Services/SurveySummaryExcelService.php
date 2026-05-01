<?php

namespace App\Services;

use App\Models\ProjectSurvey;
use App\Models\ScoringCriteria;
use App\Models\SurveyorFlow;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SurveySummaryExcelService
{
    /**
     * Departments in display order
     */
    protected array $departments = ['PROJECT', 'WORKSHOP', 'HSE'];

    /**
     * Color palette
     */
    protected array $colors = [
        'header_bg'      => '2C3E50',
        'header_font'    => 'FFFFFF',
        'dept_project'   => '3498DB',
        'dept_workshop'  => 'E67E22',
        'dept_hse'       => '27AE60',
        'score_bg'       => '8E44AD',
        'criteria_bg'    => 'ECF0F1',
        'weight_bg'      => 'D5DBDB',
        'data_alt'       => 'F9F9F9',
        'border'         => 'BDC3C7',
        'rank_bg'        => '9B59B6',
    ];

    /**
     * Generate the summary Excel file
     */
    public function generate(): string
    {
        $spreadsheet = new Spreadsheet();

        // Build "Scores" sheet
        $scoresSheet = $spreadsheet->getActiveSheet();
        $scoresSheet->setTitle('Scores');
        $this->buildScoresSheet($scoresSheet);

        // Build "Weightings" sheet
        $weightingsSheet = $spreadsheet->createSheet();
        $weightingsSheet->setTitle('Weightings');
        $this->buildWeightingsSheet($weightingsSheet);

        // Set Scores as the active sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Write to temp file
        $tempFile = tempnam(sys_get_temp_dir(), 'survey_summary_') . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($tempFile);

        return $tempFile;
    }

    /**
     * Build the main Scores sheet
     */
    protected function buildScoresSheet($sheet): void
    {
        $criteria = ScoringCriteria::orderBy('id')->get();
        $criteriaCount = $criteria->count();
        $deptCount = count($this->departments);

        // Get department weights from SurveyorFlow or survey scores
        $deptWeights = $this->getDepartmentWeights();

        // Calculate column positions
        // Col A = spacer, B = No, C = Project Code, D = Project Name, E = Status
        // Then each department has $criteriaCount columns
        // Then: Score per dept (3 cols), Total Weighted, Rank
        $dataStartCol = 6; // F = first dept criteria start
        $deptStartCols = [];
        $col = $dataStartCol;
        foreach ($this->departments as $dept) {
            $deptStartCols[$dept] = $col;
            $col += $criteriaCount;
        }
        $scoreStartCol = $col; // Where SKOR columns start
        $totalWeightedCol = $scoreStartCol + $deptCount;
        $rankCol = $totalWeightedCol + 1;
        $lastCol = $rankCol;

        // === ROW 1: Spacer ===
        $sheet->getRowDimension(1)->setRowHeight(6);

        // === ROW 2: Title ===
        $sheet->getRowDimension(2)->setRowHeight(45);
        $sheet->mergeCells($this->cellRange(2, 2, $lastCol));
        $sheet->setCellValue('B2', 'SUMMARY HASIL SURVEY PROJECT');
        $sheet->getStyle('B2')->getFont()->setBold(true)->setSize(16)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('2C3E50'));
        $sheet->getStyle('B2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        // === ROW 3: Subtitle / Date ===
        $sheet->getRowDimension(3)->setRowHeight(25);
        $sheet->mergeCells($this->cellRange(2, 3, $lastCol));
        $sheet->setCellValue('B3', 'Generated: ' . date('d M Y H:i'));
        $sheet->getStyle('B3')->getFont()->setSize(10)->setItalic(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('7F8C8D'));

        // === ROW 4: Department Headers ===
        $sheet->getRowDimension(4)->setRowHeight(30);

        // Fixed headers
        $this->setHeaderCell($sheet, 'B4', 'No', $this->colors['header_bg']);
        $this->setHeaderCell($sheet, 'C4', 'Kode Project', $this->colors['header_bg']);
        $this->setHeaderCell($sheet, 'D4', 'Nama Project', $this->colors['header_bg']);
        $this->setHeaderCell($sheet, 'E4', 'Status', $this->colors['header_bg']);

        // Merge fixed headers across rows 4-5
        foreach (['B', 'C', 'D', 'E'] as $fixedCol) {
            $sheet->mergeCells("{$fixedCol}4:{$fixedCol}5");
        }

        // Department group headers
        $deptColors = [
            'PROJECT'  => $this->colors['dept_project'],
            'WORKSHOP' => $this->colors['dept_workshop'],
            'HSE'      => $this->colors['dept_hse'],
        ];

        foreach ($this->departments as $dept) {
            $startCol = $deptStartCols[$dept];
            $endCol = $startCol + $criteriaCount - 1;
            $mergeRange = $this->colLetter($startCol) . '4:' . $this->colLetter($endCol) . '4';
            $sheet->mergeCells($mergeRange);
            $this->setHeaderCell($sheet, $this->colLetter($startCol) . '4', $dept, $deptColors[$dept] ?? $this->colors['header_bg']);
        }

        // SKOR group header
        $scoreMerge = $this->colLetter($scoreStartCol) . '4:' . $this->colLetter($lastCol) . '4';
        $sheet->mergeCells($scoreMerge);
        $this->setHeaderCell($sheet, $this->colLetter($scoreStartCol) . '4', 'SKOR', $this->colors['score_bg']);

        // === ROW 5: Criteria Names ===
        $sheet->getRowDimension(5)->setRowHeight(80);
        foreach ($this->departments as $dept) {
            $col = $deptStartCols[$dept];
            foreach ($criteria as $crit) {
                $cellRef = $this->colLetter($col) . '5';
                $sheet->setCellValue($cellRef, $crit->name);
                $this->styleCriteriaHeader($sheet, $cellRef, $deptColors[$dept] ?? $this->colors['criteria_bg']);
                $col++;
            }
        }

        // Score sub-headers in row 5
        foreach ($this->departments as $i => $dept) {
            $cellRef = $this->colLetter($scoreStartCol + $i) . '5';
            $sheet->setCellValue($cellRef, $dept);
            $this->styleCriteriaHeader($sheet, $cellRef, $deptColors[$dept] ?? $this->colors['score_bg']);
        }
        $totalCell = $this->colLetter($totalWeightedCol) . '5';
        $sheet->setCellValue($totalCell, 'Penilaian Berbobot');
        $this->styleCriteriaHeader($sheet, $totalCell, $this->colors['score_bg']);

        $rankCell = $this->colLetter($rankCol) . '5';
        $sheet->setCellValue($rankCell, 'Peringkat Prioritas');
        $this->styleCriteriaHeader($sheet, $rankCell, $this->colors['rank_bg']);

        // === ROW 6: Weights ===
        $sheet->getRowDimension(6)->setRowHeight(25);
        $sheet->mergeCells('B6:E6');
        $sheet->setCellValue('B6', 'Bobot (Dihitung)');
        $sheet->getStyle('B6')->getFont()->setBold(true)->setSize(9);
        $sheet->getStyle('B6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $this->applyFill($sheet, 'B6:E6', $this->colors['weight_bg']);

        // Calculate individual criteria weights: criteria_weight_normalized * dept_weight
        $criteriaWeightSum = $criteria->sum('weighting');

        foreach ($this->departments as $dept) {
            $col = $deptStartCols[$dept];
            $deptWeight = ($deptWeights[$dept] ?? 0) / 100; // Convert percentage to decimal
            foreach ($criteria as $crit) {
                $cellRef = $this->colLetter($col) . '6';
                $normalizedWeight = $criteriaWeightSum > 0 ? ($crit->weighting / $criteriaWeightSum) : 0;
                $weight = $normalizedWeight * $deptWeight;
                $sheet->setCellValue($cellRef, round($weight, 4));
                $sheet->getStyle($cellRef)->getNumberFormat()->setFormatCode('0.00%');
                $sheet->getStyle($cellRef)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($cellRef)->getFont()->setSize(9)->setBold(true);
                $this->applyFill($sheet, $cellRef, $this->colors['weight_bg']);
                $col++;
            }
        }

        // Weight sums per department in SKOR section
        foreach ($this->departments as $i => $dept) {
            $cellRef = $this->colLetter($scoreStartCol + $i) . '6';
            $deptStart = $this->colLetter($deptStartCols[$dept]) . '6';
            $deptEnd = $this->colLetter($deptStartCols[$dept] + $criteriaCount - 1) . '6';
            $sheet->setCellValue($cellRef, '=SUM(' . $deptStart . ':' . $deptEnd . ')');
            $sheet->getStyle($cellRef)->getNumberFormat()->setFormatCode('0.00%');
            $sheet->getStyle($cellRef)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($cellRef)->getFont()->setSize(9)->setBold(true);
            $this->applyFill($sheet, $cellRef, $this->colors['weight_bg']);
        }

        // Total weight
        $totalWeightCell = $this->colLetter($totalWeightedCol) . '6';
        $firstScoreCol = $this->colLetter($scoreStartCol) . '6';
        $lastScoreCol = $this->colLetter($scoreStartCol + $deptCount - 1) . '6';
        $sheet->setCellValue($totalWeightCell, '=SUM(' . $firstScoreCol . ':' . $lastScoreCol . ')');
        $sheet->getStyle($totalWeightCell)->getNumberFormat()->setFormatCode('0.00%');
        $sheet->getStyle($totalWeightCell)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($totalWeightCell)->getFont()->setSize(9)->setBold(true);
        $this->applyFill($sheet, $totalWeightCell, $this->colors['weight_bg']);

        // Rank column weight row - blank styled
        $this->applyFill($sheet, $this->colLetter($rankCol) . '6', $this->colors['weight_bg']);

        // === DATA ROWS ===
        $surveys = ProjectSurvey::with(['scores.criteria', 'project'])
            ->where('status', 'COMPLETED')
            ->orderBy('created_at', 'desc')
            ->get();

        $dataStartRow = 7;
        $dataEndRow = $dataStartRow + $surveys->count() - 1;

        foreach ($surveys as $rowIndex => $survey) {
            $row = $dataStartRow + $rowIndex;
            $sheet->getRowDimension($row)->setRowHeight(22);

            // Alternate row color
            if ($rowIndex % 2 === 1) {
                $this->applyFill($sheet, $this->cellRange(2, $row, $lastCol), $this->colors['data_alt']);
            }

            // No
            $sheet->setCellValue('B' . $row, $rowIndex + 1);
            $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Project Code
            $sheet->setCellValue('C' . $row, $survey->project->project_code ?? '-');

            // Project Name
            $sheet->setCellValue('D' . $row, $survey->project->project_name ?? '-');

            // Status
            $sheet->setCellValue('E' . $row, str_replace('_', ' ', $survey->status));
            $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Criteria scores per department
            foreach ($this->departments as $dept) {
                $score = $survey->scores->where('department', $dept)->first();
                $col = $deptStartCols[$dept];

                foreach ($criteria as $crit) {
                    $cellRef = $this->colLetter($col) . $row;
                    $criteriaScore = 0;

                    if ($score) {
                        $scoreCrit = $score->criteria->where('criterion_name', $crit->name)->first();
                        if ($scoreCrit) {
                            $criteriaScore = floatval($scoreCrit->score);
                        }
                    }

                    $sheet->setCellValue($cellRef, $criteriaScore);
                    $sheet->getStyle($cellRef)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle($cellRef)->getFont()->setSize(10);
                    $col++;
                }
            }

            // SKOR per department (SUMPRODUCT)
            foreach ($this->departments as $i => $dept) {
                $cellRef = $this->colLetter($scoreStartCol + $i) . $row;
                $deptStart = $this->colLetter($deptStartCols[$dept]) . '6';
                $deptEnd = $this->colLetter($deptStartCols[$dept] + $criteriaCount - 1) . '6';
                $dataStart = $this->colLetter($deptStartCols[$dept]) . $row;
                $dataEnd = $this->colLetter($deptStartCols[$dept] + $criteriaCount - 1) . $row;

                $formula = '=SUMPRODUCT($' . $this->colLetter($deptStartCols[$dept]) . '$6:$'
                    . $this->colLetter($deptStartCols[$dept] + $criteriaCount - 1) . '$6,'
                    . $dataStart . ':' . $dataEnd . ')';
                $sheet->setCellValue($cellRef, $formula);
                $sheet->getStyle($cellRef)->getNumberFormat()->setFormatCode('0.00');
                $sheet->getStyle($cellRef)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($cellRef)->getFont()->setBold(true)->setSize(10);
            }

            // Total Weighted Score (SUMPRODUCT all)
            $twCellRef = $this->colLetter($totalWeightedCol) . $row;
            $allStart = $this->colLetter($dataStartCol);
            $allEnd = $this->colLetter($dataStartCol + ($deptCount * $criteriaCount) - 1);
            $twFormula = '=SUMPRODUCT($' . $allStart . '$6:$' . $allEnd . '$6,' . $allStart . $row . ':' . $allEnd . $row . ')';
            $sheet->setCellValue($twCellRef, $twFormula);
            $sheet->getStyle($twCellRef)->getNumberFormat()->setFormatCode('0.00');
            $sheet->getStyle($twCellRef)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($twCellRef)->getFont()->setBold(true)->setSize(11);

            // Rank
            if ($surveys->count() > 0) {
                $rankCellRef = $this->colLetter($rankCol) . $row;
                $twColLetter = $this->colLetter($totalWeightedCol);
                $rankFormula = '=RANK(' . $twColLetter . $row . ',$' . $twColLetter . '$' . $dataStartRow . ':$' . $twColLetter . '$' . $dataEndRow . ')';
                $sheet->setCellValue($rankCellRef, $rankFormula);
                $sheet->getStyle($rankCellRef)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($rankCellRef)->getFont()->setBold(true)->setSize(12);
                $this->applyFill($sheet, $rankCellRef, 'F0E6F6');
            }
        }

        // === BORDERS for data area ===
        $dataRange = 'B4:' . $this->colLetter($lastCol) . ($dataEndRow > $dataStartRow ? $dataEndRow : $dataStartRow);
        $sheet->getStyle($dataRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color($this->colors['border']));

        // === Column Widths ===
        $sheet->getColumnDimension('A')->setWidth(2);
        $sheet->getColumnDimension('B')->setWidth(5);
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->getColumnDimension('D')->setWidth(35);
        $sheet->getColumnDimension('E')->setWidth(14);

        // Criteria columns
        for ($c = $dataStartCol; $c <= $lastCol; $c++) {
            $sheet->getColumnDimension($this->colLetter($c))->setWidth(12);
        }

        // SKOR/rank columns wider
        for ($c = $scoreStartCol; $c <= $lastCol; $c++) {
            $sheet->getColumnDimension($this->colLetter($c))->setWidth(14);
        }

        // === Footer ===
        $footerRow = ($dataEndRow > $dataStartRow ? $dataEndRow : $dataStartRow) + 2;
        $sheet->mergeCells($this->cellRange(2, $footerRow, $lastCol));
        $sheet->setCellValue('B' . $footerRow, 'Generated by SSB Project Management System • ' . date('d M Y H:i'));
        $sheet->getStyle('B' . $footerRow)->getFont()->setSize(9)->setItalic(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('95A5A6'));
        $sheet->getStyle('B' . $footerRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Freeze panes
        $sheet->freezePane($this->colLetter($dataStartCol) . $dataStartRow);

        // Print settings
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A3);
        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);
    }

    /**
     * Build the Weightings reference sheet
     */
    protected function buildWeightingsSheet($sheet): void
    {
        $criteria = ScoringCriteria::orderBy('id')->get();
        $deptWeights = $this->getDepartmentWeights();

        // Title
        $sheet->setCellValue('B2', 'WEIGHTINGS / BOBOT PENILAIAN');
        $sheet->getStyle('B2')->getFont()->setBold(true)->setSize(14);
        $sheet->mergeCells('B2:H2');

        $rowOffset = 4;
        foreach ($this->departments as $idx => $dept) {
            $r = $rowOffset + ($idx * 3);

            // Department name
            $sheet->setCellValue('B' . $r, $dept);
            $sheet->getStyle('B' . $r)->getFont()->setBold(true)->setSize(12);
            $this->applyFill($sheet, 'B' . $r . ':C' . $r, $this->colors['header_bg']);
            $sheet->getStyle('B' . $r)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFF'));

            // Criteria names
            $col = 4; // D
            foreach ($criteria as $crit) {
                $cellRef = $this->colLetter($col) . $r;
                $sheet->setCellValue($cellRef, $crit->name);
                $sheet->getStyle($cellRef)->getFont()->setBold(true)->setSize(9);
                $sheet->getStyle($cellRef)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setWrapText(true);
                $this->applyFill($sheet, $cellRef, $this->colors['criteria_bg']);
                $col++;
            }

            // Total header
            $totalCellRef = $this->colLetter($col) . $r;
            $sheet->setCellValue($totalCellRef, 'TOTAL');
            $sheet->getStyle($totalCellRef)->getFont()->setBold(true)->setSize(9);
            $sheet->getStyle($totalCellRef)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $this->applyFill($sheet, $totalCellRef, $this->colors['weight_bg']);

            // Weight row
            $wr = $r + 1;
            $sheet->setCellValue('B' . $wr, 'Bobot');
            $sheet->getStyle('B' . $wr)->getFont()->setBold(true);
            $sheet->setCellValue('C' . $wr, ($deptWeights[$dept] ?? 0) / 100);
            $sheet->getStyle('C' . $wr)->getNumberFormat()->setFormatCode('0%');
            $sheet->getStyle('C' . $wr)->getFont()->setBold(true);

            // Criteria weights (normalized)
            $criteriaWeightSum = $criteria->sum('weighting');
            $col = 4;
            foreach ($criteria as $crit) {
                $cellRef = $this->colLetter($col) . $wr;
                $normalizedWeight = $criteriaWeightSum > 0 ? ($crit->weighting / $criteriaWeightSum) : 0;
                $sheet->setCellValue($cellRef, round($normalizedWeight, 4));
                $sheet->getStyle($cellRef)->getNumberFormat()->setFormatCode('0.00');
                $sheet->getStyle($cellRef)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $col++;
            }

            // Total formula
            $totalWeightRef = $this->colLetter($col) . $wr;
            $startRef = 'D' . $wr;
            $endRef = $this->colLetter($col - 1) . $wr;
            $sheet->setCellValue($totalWeightRef, '=SUM(' . $startRef . ':' . $endRef . ')');
            $sheet->getStyle($totalWeightRef)->getNumberFormat()->setFormatCode('0.00');
            $sheet->getStyle($totalWeightRef)->getFont()->setBold(true);
        }

        // Total row
        $totalRow = $rowOffset + (count($this->departments) * 3) + 1;
        $sheet->setCellValue('B' . $totalRow, 'TOTAL');
        $sheet->getStyle('B' . $totalRow)->getFont()->setBold(true)->setSize(12);

        // Sum of dept weights
        $weightCells = [];
        foreach ($this->departments as $idx => $dept) {
            $weightCells[] = 'C' . ($rowOffset + ($idx * 3) + 1);
        }
        $sheet->setCellValue('C' . $totalRow, '=' . implode('+', $weightCells));
        $sheet->getStyle('C' . $totalRow)->getNumberFormat()->setFormatCode('0%');
        $sheet->getStyle('C' . $totalRow)->getFont()->setBold(true);

        // Column widths
        $sheet->getColumnDimension('A')->setWidth(2);
        $sheet->getColumnDimension('B')->setWidth(14);
        $sheet->getColumnDimension('C')->setWidth(10);
        for ($c = 4; $c <= 4 + $criteria->count(); $c++) {
            $sheet->getColumnDimension($this->colLetter($c))->setWidth(18);
        }

        // Borders
        $lastDataCol = $this->colLetter(4 + $criteria->count());
        $lastDataRow = $totalRow;
        $sheet->getStyle('B4:' . $lastDataCol . $lastDataRow)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN)
            ->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color($this->colors['border']));
    }

    /**
     * Get department weights from completed surveys
     */
    protected function getDepartmentWeights(): array
    {
        $weights = [];
        $survey = ProjectSurvey::with('scores')->where('status', 'COMPLETED')->first();

        if ($survey) {
            foreach ($survey->scores as $score) {
                $weights[$score->department] = floatval($score->weight);
            }
        }

        // Default fallback
        if (empty($weights)) {
            $weights = ['PROJECT' => 40, 'WORKSHOP' => 30, 'HSE' => 30];
        }

        return $weights;
    }

    /**
     * Helper: set a header cell with styling
     */
    protected function setHeaderCell($sheet, string $cellRef, string $value, string $bgColor): void
    {
        $sheet->setCellValue($cellRef, $value);
        $sheet->getStyle($cellRef)->getFont()->setBold(true)->setSize(11)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFF'));
        $sheet->getStyle($cellRef)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle($cellRef)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($bgColor);
    }

    /**
     * Helper: style criteria header cell
     */
    protected function styleCriteriaHeader($sheet, string $cellRef, string $bgColor): void
    {
        $sheet->getStyle($cellRef)->getFont()->setBold(true)->setSize(9)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFF'));
        $sheet->getStyle($cellRef)->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setWrapText(true)
            ->setTextRotation(90);
        $sheet->getStyle($cellRef)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($bgColor);
    }

    /**
     * Helper: apply fill color
     */
    protected function applyFill($sheet, string $range, string $color): void
    {
        $sheet->getStyle($range)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($color);
    }

    /**
     * Helper: column number to letter
     */
    protected function colLetter(int $col): string
    {
        return \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
    }

    /**
     * Helper: create a cell range string
     */
    protected function cellRange(int $startCol, int $row, int $endCol): string
    {
        return $this->colLetter($startCol) . $row . ':' . $this->colLetter($endCol) . $row;
    }
}
