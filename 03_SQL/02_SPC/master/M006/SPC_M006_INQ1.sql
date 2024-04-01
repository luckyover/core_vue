IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M006_INQ1]') AND type in (N'P', N'PC'))
DROP PROCEDURE SPC_M006_INQ1
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
-- EXEC SPC_M006_INQ1 N'', N'', N'', '::1'
--****************************************************************************************	
--*   											
--*  処理概要/process overview	:	Get detail of supplier
--*  
--*  作成日/create date			:	2024/02/19
--*　作成者/creater				:	ThuanNV - ANS909
--*   					
--*  更新日/update date			:   
--*　更新者/updater				:   
--*　更新内容/update content		:   
--****************************************************************************************
CREATE PROCEDURE SPC_M006_INQ1
	@P_supplier_cd					INT				= 0
,	@P_supplier_div					INT				= 0
,	@P_act_user_cd					NVARCHAR(10)	= N''
,	@P_prg							NVARCHAR(30)	= N''
,	@P_ip							NVARCHAR(20)	= N''
AS
BEGIN
	SET NOCOUNT ON;
	SELECT TOP 1
		M006.supplier_cd
	,   M006.supplier_div
	,   M006.supplier_nm
	,   M006.supplier_kn_nm
	,   M006.supplier_ab_nm
	,   M006.supplier_zip
	,   M006.supplier_address1
	,   M006.supplier_address2
	,   M006.supplier_address3
	,   M006.supplier_tel
	,   M006.supplier_fax
	,   M006.supplier_department_nm
	,   M006.supplier_manager_nm
	,   M006.supplier_mail_address
	,   M006.supplier_class_div1
	,   M006.supplier_class_div2
	,   M006.supplier_class_div3
	,   M006.supplier_closing_div
	,   M006.transfer_date1
	,   M006.transfer_date2
	,   M006.remarks
	,	M006.cre_user_cd
	,	cre_user.user_nm						AS cre_user_nm
	,	FORMAT(M006.cre_tm, 'yyyy/MM/dd HH:mm')	AS cre_tm
	,	M006.upd_user_cd
	,	upd_user.user_nm						AS upd_user_nm
	,	FORMAT(M006.upd_tm, 'yyyy/MM/dd HH:mm')	AS upd_tm
	FROM M006 WITH(NOLOCK)
	LEFT JOIN M002		AS	cre_user WITH(NOLOCK)	ON (
		M006.cre_user_cd				= cre_user.user_cd
	)
	LEFT JOIN M002		AS	upd_user WITH(NOLOCK)	ON (
		M006.upd_user_cd				= upd_user.user_cd
	)
	WHERE
		M006.supplier_cd				= @P_supplier_cd
	AND (
		@P_supplier_div					= 0
	OR	M006.supplier_div				= @P_supplier_div
	)
	AND M006.del_flg					<> 1
END
GO
