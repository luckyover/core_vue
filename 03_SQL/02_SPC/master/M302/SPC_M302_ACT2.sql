IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M302_ACT2]') AND type in (N'P', N'PC'))
DROP PROCEDURE SPC_M302_ACT2
    GO
    SET ANSI_NULLS ON
    GO
    SET QUOTED_IDENTIFIER ON
    GO
-- +--TEST--+
-- EXEC SPC_M302_ACT2
-- +--TEST--+
-- EXEC SPC_M302_ACT2 '[{"supplier_cd":"59","supplier_nm":"\u4ed5\u5165\u5148\u540d","item_cd":"KZT0002","item_nm":"'\u30d7\u30ea\u30f3\u30c8\u4ee3","number_sheet_fr":"1","number_sheet_to":"1","category_div":"3","material_div":"3","processing_place_div":"2","color_div":"1","sales_amt":"15","cre_user_nm":"QuyPN","cre_tm":"2024\/02\/25 14:13","upd_user_cd":"809","upd_user_nm":"QuyPN","upd_tm":"2024\/02\/25 14:13"}]','809','M302','172.19.0.1';
--****************************************************************************************
--*
--*  処理概要/process overview	:	Insert or update list data for M302
--*
--*  作成日/create date			:	2024/02/25
--*　作成者/creater				:	DungNT - ANS907
--*
--*  更新日/update date			:
--*　更新者/updater				:
--*　更新内容/update content		:
--****************************************************************************************
CREATE PROCEDURE SPC_M302_ACT2
    @P_costs							NVARCHAR(MAX)	= N''
,	@P_act_user_cd						NVARCHAR(10)	= N''
,	@P_prg								NVARCHAR(30)	= N''
,	@P_ip								NVARCHAR(20)	= N''
AS
BEGIN
	SET NOCOUNT ON;
	DECLARE
	-- variable general
		@w_time							DATETIME2		=	SYSDATETIME()
	,	@ERR_TBL						ERRTABLE
	-- variable log
    ,   @w_prs_mode						NVARCHAR(200)   =   N'Delete'
    ,   @w_prs_result					NVARCHAR(200)   =   N'OK'
	,	@w_remarks						NVARCHAR(200)	=	N''
	,	@w_table_key					NVARCHAR(200)	=	N''

	-- INIT TEMPORARY TABLES
	CREATE TABLE #TMP_PROCESS_COST_DELETE (
        supplier_cd                     NVARCHAR(30)
     ,  item_cd					        NVARCHAR(30)
     ,	category_div					SMALLINT
     ,	material_div					SMALLINT
     ,	processing_place_div			SMALLINT
     ,	number_sheet_fr		            MONEY
     ,	number_sheet_to					MONEY
     ,	color_div						SMALLINT
     ,	sales_amt						MONEY
    )

	INSERT INTO #TMP_PROCESS_COST_DELETE
    SELECT
        ISNULL(supplier_cd, '')
     ,  ISNULL(item_cd, '')
     ,	ISNULL(category_div, '')
     ,	ISNULL(material_div, '')
	 ,  ISNULL(processing_place_div, '')
     ,  ISNULL(number_sheet_fr, '')
     ,  ISNULL(number_sheet_to, '')
     ,  ISNULL(color_div, '')
     ,  ISNULL(sales_amt, '')
    FROM OPENJSON (@P_costs)
    WITH (
        supplier_cd                     NVARCHAR(30)
     ,  item_cd					        NVARCHAR(30)
     ,	category_div					SMALLINT
     ,	material_div					SMALLINT
     ,	processing_place_div			SMALLINT
     ,	number_sheet_fr		            MONEY
     ,	number_sheet_to					MONEY
     ,	color_div						SMALLINT
     ,	sales_amt						MONEY
    ) AS TMP

    -- START TRANSACTION
    BEGIN TRANSACTION
    -- TRY CATCH EXCEPTION
    BEGIN TRY
		-- DELETE TABLE PROCESS COST
        UPDATE M302 SET
                    del_user_cd			= @P_act_user_cd
                  ,	del_prg				= @P_prg
                  ,	del_ip				= @P_ip
                  ,	del_tm				= @w_time
                  ,	del_flg				= 1
        FROM M302
        INNER JOIN #TMP_PROCESS_COST_DELETE AS tmp_delete		ON (
            M302.supplier_cd            = tmp_delete.supplier_cd
		AND	M302.item_cd				= tmp_delete.item_cd
		AND	M302.category_div			= tmp_delete.category_div
        AND M302.material_div			= tmp_delete.material_div
		AND M302.processing_place_div	= tmp_delete.processing_place_div
		AND M302.number_sheet_fr		= tmp_delete.number_sheet_fr
		AND M302.number_sheet_to		= tmp_delete.number_sheet_to
		AND M302.color_div				= tmp_delete.color_div
        )

    END TRY
    BEGIN CATCH
        SET @w_prs_result				=   'NG'
        SET @w_remarks					=	N'Error'															+ CHAR(13) + CHAR(10) +
										N'Procedure : ' + ISNULL(ERROR_PROCEDURE(), N'???')						+ CHAR(13) + CHAR(10) +
										N'Line : '      + ISNULL(CAST(ERROR_LINE() AS NVARCHAR(10)), N'0')		+ CHAR(13) + CHAR(10) +
										N'Message : '   + ISNULL(ERROR_MESSAGE(), N'An unexpected error occurred.')
        DELETE FROM @ERR_TBL
        INSERT INTO @ERR_TBL
        SELECT
                 N'E009'
             ,   N''
             ,   0
             ,   999
             ,   0
             ,	 N''
             ,   @w_remarks
    END CATCH

    IF EXISTS (SELECT 1 FROM @ERR_TBL)
    BEGIN
        IF(@@TRANCOUNT > 0)
        BEGIN
            ROLLBACK TRANSACTION
        END
    END
    ELSE
        BEGIN
            DELETE FROM @ERR_TBL
            IF(@@TRANCOUNT > 0)
            BEGIN
                COMMIT TRANSACTION
        END
    END
    -- Insert statements for procedure here
	COMPLETE_QUERY:

	EXEC SPC_S999_ACT1
		@P_act_user_cd
	,	@P_prg
	,	@w_prs_mode
	,	@w_table_key
	,	@w_prs_result
	,	@w_remarks

    SELECT * FROM @ERR_TBL

    DROP TABLE IF EXISTS #TMP_PROCESS_COST_INSERT
    DROP TABLE IF EXISTS #TMP_PROCESS_COST_DELETE
    DROP TABLE IF EXISTS #TMP_PROCESS_COST_UPDATE
END