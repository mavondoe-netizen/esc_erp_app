-- Migration to add manual_reference to accounting and procurement models
USE eras_app;

-- Accounting / Finance
ALTER TABLE invoices ADD COLUMN manual_reference VARCHAR(100) NULL;
ALTER TABLE bills ADD COLUMN manual_reference VARCHAR(100) NULL;
ALTER TABLE payments ADD COLUMN manual_reference VARCHAR(100) NULL;
ALTER TABLE receipts ADD COLUMN manual_reference VARCHAR(100) NULL;
ALTER TABLE transactions ADD COLUMN manual_reference VARCHAR(100) NULL;

-- Procurement
ALTER TABLE requisitions ADD COLUMN manual_reference VARCHAR(100) NULL;
ALTER TABLE procurements ADD COLUMN manual_reference VARCHAR(100) NULL;
ALTER TABLE tenders ADD COLUMN manual_reference VARCHAR(100) NULL;
ALTER TABLE tender_bids ADD COLUMN manual_reference VARCHAR(100) NULL;
ALTER TABLE evaluations ADD COLUMN manual_reference VARCHAR(100) NULL;
ALTER TABLE awards ADD COLUMN manual_reference VARCHAR(100) NULL;
ALTER TABLE contracts ADD COLUMN manual_reference VARCHAR(100) NULL;
ALTER TABLE goods_receipts ADD COLUMN manual_reference VARCHAR(100) NULL;

-- Loans
ALTER TABLE loan_applications ADD COLUMN manual_reference VARCHAR(100) NULL;
ALTER TABLE loans ADD COLUMN manual_reference VARCHAR(100) NULL;
ALTER TABLE loan_repayments ADD COLUMN manual_reference VARCHAR(100) NULL;
