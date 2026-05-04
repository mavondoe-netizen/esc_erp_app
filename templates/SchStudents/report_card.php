<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SchStudent $schStudent
 * @var \App\Model\Entity\Company $company
 */
$this->assign('title', 'Academic Report Card - ' . h($schStudent->user->name));
?>
<div class="report-card">
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 4px solid #4f46e5; padding-bottom: 20px; margin-bottom: 30px;">
        <div>
            <?php if ($company->logo): ?>
                <img src="<?= $company->logo ?>" style="max-height: 80px; margin-bottom: 10px;">
            <?php else: ?>
                <h2 style="color: #4f46e5; margin: 0; font-weight: 800;"><?= h($company->name) ?></h2>
            <?php endif; ?>
            <p style="color: #64748b; font-size: 0.9rem; margin: 0;"><?= h($company->address) ?></p>
        </div>
        <div style="text-align: right;">
            <h1 style="margin: 0; font-size: 2.5rem; color: #1e293b; text-transform: uppercase; font-weight: 900;">Report Card</h1>
            <p style="color: #4f46e5; font-weight: 700; font-size: 1.1rem; margin: 0;">ACADEMIC YEAR: <?= date('Y') ?></p>
        </div>
    </div>

    <!-- Student Info Bar -->
    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 25px; margin-bottom: 30px; display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
        <div>
            <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 4px;">Student Name</label>
            <span style="font-size: 1.1rem; font-weight: 700; color: #0f172a;"><?= h($schStudent->user->name) ?></span>
        </div>
        <div>
            <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 4px;">Admission Number</label>
            <span style="font-size: 1.1rem; font-weight: 700; color: #0f172a;"><?= h($schStudent->admission_no) ?></span>
        </div>
        <div>
            <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 4px;">Class / Grade</label>
            <span style="font-size: 1.1rem; font-weight: 700; color: #4f46e5;"><?= h($schStudent->sch_class->name) ?> <?= h($schStudent->sch_class->section) ?></span>
        </div>
    </div>

    <!-- Results Table -->
    <table class="no-dt" style="width: 100%; border-collapse: collapse; margin-bottom: 40px; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);">
        <thead>
            <tr style="background: #4f46e5; color: white; text-align: left;">
                <th style="padding: 15px 20px;">Subject</th>
                <th style="padding: 15px 20px;">Term</th>
                <th style="padding: 15px 20px; text-align: center;">Marks (%)</th>
                <th style="padding: 15px 20px; text-align: center;">Grade</th>
                <th style="padding: 15px 20px;">Teacher Remarks</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($schStudent->sch_results)): ?>
                <?php foreach ($schStudent->sch_results as $index => $result): ?>
                <tr style="background: <?= $index % 2 === 0 ? '#ffffff' : '#f8fafc' ?>; border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 15px 20px; font-weight: 700; color: #1e293b;"><?= h($result->sch_subject->name) ?></td>
                    <td style="padding: 15px 20px; color: #64748b;"><?= h($result->sch_exam->term) ?></td>
                    <td style="padding: 15px 20px; text-align: center; font-weight: 800; color: #0f172a;"><?= number_format($result->marks, 1) ?>%</td>
                    <td style="padding: 15px 20px; text-align: center;">
                        <span style="background: #dcfce7; color: #166534; padding: 4px 12px; border-radius: 20px; font-weight: 800; font-size: 0.85rem;"><?= h($result->grade) ?></span>
                    </td>
                    <td style="padding: 15px 20px; color: #475569; font-style: italic; font-size: 0.9rem;"><?= h($result->remarks ?: 'Great performance.') ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5" style="padding: 40px; text-align: center; color: #94a3b8; font-style: italic;">No results recorded for this period.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Grading Scale & Footer -->
    <div style="display: grid; grid-template-columns: 2fr 1.5fr; gap: 40px; align-items: start;">
        <div>
            <h5 style="font-weight: 800; text-transform: uppercase; color: #475569; font-size: 0.85rem; margin-bottom: 15px;">Grading Key</h5>
            <div style="display: flex; gap: 15px; font-size: 0.8rem; color: #64748b;">
                <span style="background: #f1f5f9; padding: 4px 10px; border-radius: 4px;"><strong>A:</strong> 80-100%</span>
                <span style="background: #f1f5f9; padding: 4px 10px; border-radius: 4px;"><strong>B:</strong> 70-79%</span>
                <span style="background: #f1f5f9; padding: 4px 10px; border-radius: 4px;"><strong>C:</strong> 60-69%</span>
                <span style="background: #f1f5f9; padding: 4px 10px; border-radius: 4px;"><strong>D:</strong> 50-59%</span>
                <span style="background: #f1f5f9; padding: 4px 10px; border-radius: 4px;"><strong>U:</strong> < 50%</span>
            </div>
        </div>
        <div style="text-align: right;">
            <div style="border-top: 1px solid #e2e8f0; padding-top: 20px; margin-top: 20px;">
                <p style="margin: 0; font-weight: 700; color: #1e293b;">Principal's Signature</p>
                <div style="height: 60px; margin-top: 10px; border-bottom: 2px dashed #cbd5e1; width: 200px; display: inline-block;"></div>
            </div>
        </div>
    </div>

    <div style="margin-top: 50px; text-align: center; color: #94a3b8; font-size: 0.75rem; border-top: 1px dashed #e2e8f0; padding-top: 20px;">
        This document is an official academic transcript. Verified by <?= h($company->name) ?> School Management System.
    </div>
</div>
