SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
-- EXEC [SPC_M202_INQ1] 'ITEM1','','','','','','','M202','172.19.0.1';
--****************************************************************************************
--*   											
--*  処理概要/process overview	:	Get detail of product cart master
--*  
--*  作成日/create date			:	2024/02/22
--*　作成者/creater				:	HaiNN - ANS901
--*   					
--*  更新日/update date			:   
--*　更新者/updater				:   
--*　更新内容/update content		:   
--****************************************************************************************
CREATE PROCEDURE [dbo].[SPC_M202_INQ1]
	@P_item_cd						NVARCHAR(30)	= N''
,	@P_color_cd						NVARCHAR(10)	= N''
,	@P_item_nm						NVARCHAR(255)	= N''
,	@P_size_cd						NVARCHAR(10)	= N''
,	@P_supplier_cd					INT				= 0
,	@P_supplier_nm					NVARCHAR(255)	= N''
,	@P_act_user_cd					NVARCHAR(10)	= N''
,	@P_prg							NVARCHAR(30)	= N''
,	@P_ip							NVARCHAR(20)	= N''
AS
BEGIN
	SET NOCOUNT ON;
	SELECT
		ISNULL(M202.item_cd				,'')		AS	item_cd
	,	MAX(ISNULL(m_item.item_nm		,''))		AS	item_nm	
	,	ISNULL(M202.color_cd			,'')		AS	color_cd
	,	MAX(ISNULL(m_item.color_nm		,''))		AS	color_nm
	,	ISNULL(M202.size_cd				,'')		AS	size_cd
	,	ISNULL(M202.supplier_cd			,'')		AS	supplier_cd
	,	MAX(ISNULL(m_supplier.supplier_nm	,''))	AS	supplier_nm
	,	MAX(ISNULL(M202.retail_upr			,''))	AS	retail_upr
	FROM M202 WITH(NOLOCK)
	LEFT JOIN M101		AS	m_item WITH(NOLOCK)	ON (
		M202.item_cd					= m_item.item_cd
	AND m_item.del_flg					<> 1
	)
	LEFT JOIN M006		AS	m_supplier WITH(NOLOCK)	ON (
		M202.supplier_cd				= m_supplier.supplier_cd
	AND m_supplier.del_flg				<> 1
	)
	LEFT JOIN M102		AS	m_size WITH(NOLOCK)	ON (
		M202.item_cd					= m_size.item_cd
	AND M202.color_cd					= m_size.color_cd
	AND	m_size.del_flg				<> 1
	)
	WHERE
		(M202.item_cd					= @P_item_cd						OR @P_item_cd = N'')
	AND (M202.color_cd					= @P_color_cd						OR @P_color_cd = N'')
	AND	(M202.size_cd					= @P_size_cd						OR @P_size_cd = N'')
	AND	(M202.supplier_cd				= @P_supplier_cd					OR @P_supplier_cd = 0)
	AND	(m_supplier.supplier_nm			LIKE '%' +  @P_supplier_nm + '%'	OR @P_supplier_nm = N'')
	AND (m_item.item_nm					LIKE '%' +  @P_item_nm + '%'		OR @P_item_nm = N'')
	--AND m_item.item_class_div			<> 2
	AND M202.del_flg					<> 1
	GROUP BY
		M202.item_cd,
		M202.color_cd,
		M202.size_cd,
		M202.supplier_cd,
		M202.retail_upr
END
