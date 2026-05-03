<?php use App\Config\Lang; ?>
<div class="modal" id="userManualModal">
    <div class="modal-box manual-modal-box">
        <button class="modal-close" data-close>&times;</button>
        <h2><?= t('manual_title') ?></h2>

        <div class="manual-tabs">
            <button class="manual-tab active" onclick="manualTab('emp',this)" type="button">
                <?= t('manual_employee_tab') ?>
            </button>
            <button class="manual-tab" onclick="manualTab('own',this)" type="button">
                <?= t('manual_owner_tab') ?>
            </button>
        </div>

        <!-- Employee section -->
        <div class="manual-section" id="manual-emp">
            <h3 class="manual-role-h"><?= t('manual_emp_h') ?></h3>

            <div class="manual-item">
                <div class="manual-item-icon">1</div>
                <div>
                    <strong><?= t('manual_emp_1_h') ?></strong>
                    <p><?= t('manual_emp_1_b') ?></p>
                </div>
            </div>
            <div class="manual-item">
                <div class="manual-item-icon">2</div>
                <div>
                    <strong><?= t('manual_emp_2_h') ?></strong>
                    <p><?= t('manual_emp_2_b') ?></p>
                </div>
            </div>
            <div class="manual-item">
                <div class="manual-item-icon">3</div>
                <div>
                    <strong><?= t('manual_emp_3_h') ?></strong>
                    <p><?= t('manual_emp_3_b') ?></p>
                </div>
            </div>
            <div class="manual-item">
                <div class="manual-item-icon">4</div>
                <div>
                    <strong><?= t('manual_emp_4_h') ?></strong>
                    <p><?= t('manual_emp_4_b') ?></p>
                </div>
            </div>
            <div class="manual-item">
                <div class="manual-item-icon">5</div>
                <div>
                    <strong><?= t('manual_emp_5_h') ?></strong>
                    <p><?= t('manual_emp_5_b') ?></p>
                </div>
            </div>
            <div class="manual-item">
                <div class="manual-item-icon">6</div>
                <div>
                    <strong><?= t('manual_emp_6_h') ?></strong>
                    <p><?= t('manual_emp_6_b') ?></p>
                </div>
            </div>
        </div>

        <!-- Owner section -->
        <div class="manual-section" id="manual-own" style="display:none">
            <h3 class="manual-role-h"><?= t('manual_own_h') ?></h3>
            <p class="manual-intro"><?= t('manual_own_intro') ?></p>

            <div class="manual-item">
                <div class="manual-item-icon owner">1</div>
                <div>
                    <strong><?= t('manual_own_1_h') ?></strong>
                    <p><?= t('manual_own_1_b') ?></p>
                </div>
            </div>
            <div class="manual-item">
                <div class="manual-item-icon owner">2</div>
                <div>
                    <strong><?= t('manual_own_2_h') ?></strong>
                    <p><?= t('manual_own_2_b') ?></p>
                </div>
            </div>
            <div class="manual-item">
                <div class="manual-item-icon owner">3</div>
                <div>
                    <strong><?= t('manual_own_3_h') ?></strong>
                    <p><?= t('manual_own_3_b') ?></p>
                </div>
            </div>
            <div class="manual-item">
                <div class="manual-item-icon owner">4</div>
                <div>
                    <strong><?= t('manual_own_4_h') ?></strong>
                    <p><?= t('manual_own_4_b') ?></p>
                </div>
            </div>
            <div class="manual-item">
                <div class="manual-item-icon owner">5</div>
                <div>
                    <strong><?= t('manual_own_5_h') ?></strong>
                    <p><?= t('manual_own_5_b') ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function manualTab(section, btn) {
    document.querySelectorAll('.manual-section').forEach(function(s){ s.style.display = 'none'; });
    document.querySelectorAll('.manual-tab').forEach(function(b){ b.classList.remove('active'); });
    document.getElementById('manual-' + section).style.display = 'block';
    btn.classList.add('active');
}
</script>
