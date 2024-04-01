IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M101_INQ4]') AND type in (N'P', N'PC'))
DROP PROCEDURE SPC_M101_INQ4
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
-- EXEC SPC_M101_INQ4 'ITEM1','','809','M101','172.19.0.1';
--****************************************************************************************
--*   											
--*  処理概要/process overview	:	Refer name of product
--*  
--*  作成日/create date			:	2024/02/22
--*　作成者/creater				:	QuyPN - ANS809
--*   					
--*  更新日/update date			:   
--*　更新者/updater				:   
--*　更新内容/update content		:   
--****************************************************************************************
CREATE PROCEDURE SPC_M101_INQ4
	@P_item_cd						NVARCHAR(30)	= N''
,	@P_color_cd						NVARCHAR(30)	= N''
,	@P_item_class_div				INT				= 0
,	@P_act_user_cd					NVARCHAR(10)	= N''
,	@P_prg							NVARCHAR(30)	= N''
,	@P_ip							NVARCHAR(20)	= N''
AS
BEGIN
	SET NOCOUNT ON;
	SELECT TOP 1
		M101.item_cd
	,	M101.color_cd
	,	M101.item_nm
	,	M101.item_kn_nm
	,	M101.item_ab_nm
	,	M101.color_nm
	,	M101.color_kn_nm
	,	M101.color_ab_nm
	,	M101.item_class_div
	,	M101.process_div
	,	M101.category_div
	,	M101.material_div
	,	M101.supplier_cd
	,	M101.supplier_item_cd
	,	M101.tax_div
	,	M101.remarks
	,	M006.supplier_nm
	,	M101.cre_user_cd
	,	cre_user.user_nm						AS cre_user_nm
	,	FORMAT(M101.cre_tm, 'yyyy/MM/dd HH:mm')	AS cre_tm
	,	M101.upd_user_cd
	,	upd_user.user_nm						AS upd_user_nm
	,	FORMAT(M101.upd_tm, 'yyyy/MM/dd HH:mm')	AS upd_tm
	FROM M101 WITH(NOLOCK)
	LEFT JOIN M002		AS	cre_user WITH(NOLOCK)	ON (
		M101.cre_user_cd				= cre_user.user_cd
	)
	LEFT JOIN M002		AS	upd_user WITH(NOLOCK)	ON (
		M101.upd_user_cd				= upd_user.user_cd
	)
	LEFT JOIN M006									ON (
		M101.supplier_cd				= M006.supplier_cd
	AND M006.del_flg					<> 1
	)
	WHERE
		M101.item_cd					= @P_item_cd
	AND (
		@P_item_class_div				= 0
	OR	(
			@P_item_class_div			= -1
		AND  M101.item_class_div		<> 2
	)
	OR  M101.item_class_div				= @P_item_class_div
	)
	AND (
		@P_item_class_div				= 2
	OR  M101.color_cd					= @P_color_cd
	)
	AND M101.del_flg					<> 1
END
GO
